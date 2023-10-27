<?php

namespace App\Http\Controllers;

use App\Models\Acompanhamento;
use App\Models\Contribuinte;
use App\Models\Departamento;
use App\Models\Protocolo;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProtocolosController extends Controller
{
    public function index()
    {
        if(Auth::user()->perfil === 0 || Auth::user()->perfil === 1) //admin da TI e do Sistema, tem acesso à todos os protocolos
        {
            $protocolos = Protocolo::all();

            $protocolos->load(['contribuinte:id,nome', 'departamento:id,nome']);
        }
        else
        {
            $user = Auth::user();
            $departamentos = $user->departamentos()->pluck('departamento_id');

            $protocolos = Protocolo::whereIn('departamento_id', $departamentos)->get();
            
            $protocolos->load(['contribuinte:id,nome', 'departamento:id,nome']);
        }

        return Inertia::render('Protocolos/Index', ['protocolos' => $protocolos]);
    }

    // public function index(Request $request)
    // {
    //     if(Auth::user()->perfil === 0 || Auth::user()->perfil === 1) //admin da TI e do Sistema, tem acesso à todos os protocolos
    //     {
    //         $pesquisa = $request->get('pesquisa');

    //         $query = Protocolo::query();

    //         if ($pesquisa) {
    //             $query->WhereRelation('contribuinte', 'nome', 'like', '%' . $pesquisa . '%')
    //                 ->orWhere('descricao', 'LIKE', "%{$pesquisa}%");
    //         }

    //         $protocolos = $query->with(['contribuinte:id,nome', 'departamento:id,nome'])
    //             ->paginate(15)->withQueryString();
            
    //         //$protocolos = Protocolo::with(['contribuinte:id,nome', 'departamento:id,nome'])->paginate(15);
    //     }
    //     else
    //     {
    //         $user = Auth::user();
    //         $departamentos = $user->departamentos()->pluck('departamento_id');

    //         $pesquisa = $request->get('pesquisa');

    //         $query = Protocolo::query()->whereIn('departamento_id', $departamentos)
    //             ->with(['contribuinte:id,nome', 'departamento:id,nome']);

    //         if ($pesquisa) {
    //             $query->WhereRelation('contribuinte', 'nome', 'like', '%' . $pesquisa . '%')
    //                 ->orWhere('descricao', 'LIKE', "%{$pesquisa}%")
    //                 ->whereIn('departamento_id', $departamentos);
    //     }

    //         $protocolos = $query->with(['contribuinte:id,nome', 'departamento:id,nome'])
    //             ->paginate(15)->withQueryString();
    //     }

    //     return Inertia::render('Protocolos/Index', [
    //         'protocolos' => $protocolos,
    //         'filters' => $request->only(['pesquisa'])
    //     ]);
    // }

    public function create()
    {
        $departamentos = null;

        if(Auth::user()->perfil === 0 || Auth::user()->perfil === 1)
        {
            //$departamentos = Departamento::all();    
            $departamentos = Departamento::orderBy('nome')->get();
        }
        else
        {
            $user = Auth::user();
            $departamentos = $user->departamentos()->orderBy('nome')->get();
        }

        //$contribuintes = Contribuinte::orderBy('nome')->get();
        $contribuintes = Contribuinte::orderBy('nome')->select('id', 'cpf', 'nome')->get();
        //dd($contribuintes);

        return Inertia::render('Protocolos/Create', [
            'departamentos' => $departamentos,
            'contribuintes' => $contribuintes,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'contribuinte_id' => 'required|exists:contribuintes,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'descricao' => 'required|string|max:255',
            'prazo' => 'required|integer',
        ]);

        Protocolo::create($attributes);

        return to_route('protocolos-index');
    }

    public function show($id)
    {
        //$protocolo = Protocolo::where('id', $id)->with('departamento', 'contribuinte','acompanhamentos')->firstOrFail();
        $protocolo = Protocolo::where('id', $id)->with('departamento:id,nome','contribuinte:id,nome')->firstOrFail();
        
        if(Auth::user()->perfil === 2)
        {
            $user = Auth::user();
            $departamentos_id = $user->departamentos()->pluck('departamento_id')->toArray();

            //se o departamento_id do protocolo nao tiver no array de departamentos_id do user, 
            //nao deixa visualizar
            if(in_array($protocolo->departamento_id, $departamentos_id) === false)
            {
                return to_route('home');
            }
        }

        $acompanhamentos = $protocolo->acompanhamentos()->orderBy('id', 'desc')->get();

        $acompanhamentos->load(['user:id,name']);
        //$contribuinte

        //dd($acompanhamentos);

        return Inertia::render('Protocolos/Show', [
            'protocolo' => $protocolo,
            'acompanhamentos' => $acompanhamentos
        ]);
    }

    public function edit($id)
    {
        $protocolo = Protocolo::where('id', $id)->firstOrFail();

        if(Auth::user()->perfil === 0 || Auth::user()->perfil === 1) //Se for Admin TI ou Sistema, tem acesso a todos os departamentos
        {
            $departamentos = Departamento::orderBy('nome')->get();
        }
        else
        {
            $user = Auth::user();
            $departamentos_id = $user->departamentos()->pluck('departamento_id')->toArray();

            //se o departamento_id do protocolo nao tiver no array de departamentos_id do user, 
            //nao deixa editar
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

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'contribuinte_id' => 'required|exists:contribuintes,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'descricao' => 'required|string|max:255',
            'situacao' => 'required|integer|in:0,1',
            'prazo' => 'required|integer',
        ]);

        Protocolo::where('id', $id)->update($data);

        return to_route('protocolos-index');
    }

    public function destroy($id)
    {
        Protocolo::where('id', $id)->delete();

        //return to_route('protocolos-index');
        return redirect()->back();
    }

    public function addAcompanhamento(Request $request)
    {
        $attributes = $request->validate([
            'observacao' => 'required|string|max:255',
            'protocolo_id' => 'required|exists:protocolos,id',
            'user_id' => 'required|exists:users,id',
        ]);
        
       //dd($attributes);

        Acompanhamento::create($attributes);

        return redirect()->back()->with('success','DEU');
    }
}
