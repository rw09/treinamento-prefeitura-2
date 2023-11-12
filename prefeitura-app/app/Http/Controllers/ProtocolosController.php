<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\AcompanhamentoRequest;
use App\Http\Requests\AnexoRequest;
use App\Http\Requests\ProtocoloRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Acompanhamento;
use App\Models\Anexo;
use App\Models\Contribuinte;
use App\Models\Departamento;
use App\Models\Protocolo;
use Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProtocolosController extends Controller
{
    public function index()
    {
        if(Auth::user()->perfil === 0 || Auth::user()->perfil === 1)
        {
            //$protocolos = Protocolo::withCount('acompanhamentos')->get();
            $protocolos = Protocolo::withCount('acompanhamentos')->withCount('anexos')->get();

            $protocolos->load(['contribuinte:id,nome', 'departamento:id,nome']);
        }
        else
        {
            $user = Auth::user();
            
            $departamentos = $user->departamentos()->pluck('departamento_id');

            $protocolos = Protocolo::whereIn('departamento_id', $departamentos)->withCount('acompanhamentos')->withCount('anexos')->get();
            
            $protocolos->load(['contribuinte:id,nome', 'departamento:id,nome']);
        }

        return Inertia::render('Protocolos/Index', ['protocolos' => $protocolos]);
    }


    public function create()
    {
        $departamentos = null;

        if(Auth::user()->perfil === 0 || Auth::user()->perfil === 1)
        {
            $departamentos = Departamento::orderBy('nome')->get();
        }
        else
        {
            $user = Auth::user();
            
            $departamentos = $user->departamentos()->orderBy('nome')->get();
        }

        $contribuintes = Contribuinte::orderBy('nome')->select('id', 'cpf', 'nome')->get();

        return Inertia::render('Protocolos/Create', [
            'departamentos' => $departamentos,
            'contribuintes' => $contribuintes,
        ]);
    }

    public function store(ProtocoloRequest $request)
    {
        //dd($request->all());
        $validated = $request->validated();

        $protocolo = Protocolo::create($validated);

        if($request->hasFile('anexos')) 
        {
            foreach ($request->file('anexos') as $file)
            {
                $path = $file->storeAs(
                    'Anexos/Protocolo-'. $protocolo->id, $file->getClientOriginalName()
                );

                Anexo::create([
                    'name' => $file->getClientOriginalName(),
                    'extensao' => $file->getClientOriginalExtension(),
                    'caminho' => $path,
                    'protocolo_id' => $protocolo->id,
                ]);
            }
        }

        return to_route('protocolos-index')->with('message', 'Protocolo Cadastrado com Sucesso!');
    }

    public function show($id)
    {
        //$protocolo = Protocolo::where('id', $id)->with('departamento:id,nome','contribuinte:id,nome')->firstOrFail();
        $protocolo = Protocolo::where('id', $id)->with('departamento:id,nome','contribuinte')->firstOrFail();

        if(Auth::user()->perfil === 2)
        {
            $user = Auth::user();

            $departamentos_id = $user->departamentos()->pluck('departamento_id')->toArray();

            //se o departamento_id do protocolo nao tiver no array de departamentos_id do user, nao deixa visualizar
            if(in_array($protocolo->departamento_id, $departamentos_id) === false)
            {
                return to_route('home');
            }
        }

        $acompanhamentos = $protocolo->acompanhamentos()->orderBy('id', 'desc')->get();
        $acompanhamentos->load(['user:id,name']);

        $anexos = $protocolo->anexos()->orderBy('id', 'desc')->get();
        //dd($anexos);
        
        
        return Inertia::render('Protocolos/Show', [
            'protocolo' => $protocolo,
            'acompanhamentos' => $acompanhamentos,
            'anexos' => $anexos,
        ]);
    }

    public function download($id)
    {
        $anexo = Anexo::find($id);

        return Storage::download($anexo->caminho);
    }

    public function edit($id)
    {
        $protocolo = Protocolo::where('id', $id)->firstOrFail();

        if(Auth::user()->perfil === 0 || Auth::user()->perfil === 1)
        {
            $departamentos = Departamento::orderBy('nome')->get();
        }
        else
        {
            $user = Auth::user();

            $departamentos_id = $user->departamentos()->pluck('departamento_id')->toArray();

            //se o departamento_id do protocolo nao tiver no array de departamentos_id do user, nao deixa editar
            if(in_array($protocolo->departamento_id, $departamentos_id))
            {
                $departamentos = $user->departamentos()->orderBy('nome')->get();
            }
            else
            {
                return to_route('home');
            }
        }        

        $contribuintes = Contribuinte::orderBy('nome')->get();

        return Inertia::render('Protocolos/Edit', [
            'protocolo' => $protocolo,
            'departamentos' => $departamentos,
            'contribuintes' => $contribuintes,
        ]);
    }

    public function update(ProtocoloRequest $request, $id)
    {
        $validated = $request->validated();

        Protocolo::find($id)->update($validated);

        return to_route('protocolos-index')->with('message', 'Protocolo Editado com Sucesso!');
    }

    public function destroy($id)
    {
        Protocolo::find($id)->delete();

        return redirect()->back();
    }

    public function addAcompanhamento(AcompanhamentoRequest $request) //usar notificação depois e passar pro AcompanhamentosController
    {
        $validated = $request->validated();

        Acompanhamento::create($validated);

        return redirect()->back()->with('message', 'Acompanhamento Registrado com Sucesso!');
    }

    public function removeAcompanhamento( $id)
    {
        $acompanhamento = Acompanhamento::where('id', $id)->firstOrFail();

        $acompanhamento->delete();
        
        return redirect()->back()->with('message', 'Acompanhamento Removido com Sucesso!');
    }

    public function addAnexo(AnexoRequest $request)
    {
        //dd($request);
        if($request->hasFile('anexos')) 
        {
            foreach ($request->file('anexos') as $file)
            {
                $name = $file->getClientOriginalName();

                if(Storage::exists('Anexos/Protocolo-'. $request->protocolo_id .'/'. $name))
                {
                    $path = 'Anexos/Protocolo-'. $request->protocolo_id .'/'. $file->getClientOriginalName();
                    
                    while(Storage::exists($path))
                    {
                        $name = $file->hashName();
                        $path = 'Anexos/Protocolo-'. $request->protocolo_id .'/'. $name;
                    }

                    //return redirect()->back()->with('message', $name);
                }

                $path = $file->storeAs('Anexos/Protocolo-'. $request->protocolo_id, $name);
                
                Anexo::create([
                    'name' => $name,
                    'extensao' => $file->getClientOriginalExtension(),
                    'caminho' => $path,
                    'protocolo_id' => $request->protocolo_id,
                ]);
            }
            return redirect()->back()->with('message', 'Arquivo Anexado com Sucesso!');
        } else {
            return redirect()->back()->with('message','NAO FOI POSSIVEL ANEXAR');
        }
    }

    public function removeAnexo(AnexoRequest $request, $id)
    {
        //dd($id);
        //dd($request);
        $protocolo = Protocolo::where('id', $request->protocolo_id)->firstOrFail();

        $anexo = Anexo::where('id', $id)->firstOrFail();
        Storage::delete($anexo->caminho);

        $anexo->delete();
        
        
        
        //$protocolo->anexos()->detach($anexo);
        
        return redirect()->back()->with('message', 'Anexo Removido com Sucesso!');
    }

    public function relatorio(Request $request)
    {

        $protocolos_ids = $request->protocolo_ids;
        
        //para pegar pela ordem dos ids do db
        //$protocolos = Protocolo::whereIn('id', $protocolos_ids)->get();

        //para pegar pela ordem do datatable
        $protocolos = collect();

        foreach($protocolos_ids as $protocolo_id) 
        {
            $protocolo = Protocolo::find($protocolo_id);
            $protocolo->load('contribuinte');
            $protocolos->push($protocolo);
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('relatorio', ['protocolos'=> $protocolos]);
        return $pdf->stream();
    }

    public function pdf(Request $request)
    {
        $protocolo = Protocolo::find($request->protocolo);
        
        //$protocolo->load(['acompanhamentos']);
        $acompanhamentos = $protocolo->acompanhamentos()->get();

        $pdf = App::make('dompdf.wrapper');
        //$pdf->loadView('pdf', ['protocolo'=> $protocolo]);
        $pdf->loadView('pdf', compact('protocolo', 'acompanhamentos'));
        //$pdf->loadView('pdf', ['acompanhamentos' => $acompanhamentos]);
        return $pdf->stream();
    }
}
