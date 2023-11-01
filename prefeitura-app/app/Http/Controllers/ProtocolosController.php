<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcompanhamentoRequest;
use App\Http\Requests\ProtocoloRequest;
use App\Models\Acompanhamento;
use App\Models\Contribuinte;
use App\Models\Departamento;
use App\Models\Protocolo;
use Auth;
use Inertia\Inertia;

class ProtocolosController extends Controller
{
    public function index()
    {
        if(Auth::user()->perfil === 0 || Auth::user()->perfil === 1)
        {
            $protocolos = Protocolo::withCount('acompanhamentos')->get();

            $protocolos->load(['contribuinte:id,nome', 'departamento:id,nome']);
        }
        else
        {
            $user = Auth::user();
            
            $departamentos = $user->departamentos()->pluck('departamento_id');

            $protocolos = Protocolo::whereIn('departamento_id', $departamentos)->withCount('acompanhamentos')->get();
            
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
        $validated = $request->validated();

        Protocolo::create($validated);

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
        
        return Inertia::render('Protocolos/Show', [
            'protocolo' => $protocolo,
            'acompanhamentos' => $acompanhamentos
        ]);
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

        Protocolo::where('id', $id)->update($validated);

        return to_route('protocolos-index')->with('message', 'Protocolo Editado com Sucesso!');
    }

    public function destroy($id)
    {
        Protocolo::where('id', $id)->delete();

        return redirect()->back();
    }

    public function addAcompanhamento(AcompanhamentoRequest $request) //usar notificação depois e passar pro AcompanhamentosController
    {
        $validated = $request->validated();

        Acompanhamento::create($validated);

        return redirect()->back()->with('success','DEU');
    }
}
