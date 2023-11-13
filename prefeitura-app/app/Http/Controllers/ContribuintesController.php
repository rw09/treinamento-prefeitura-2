<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContribuinteRequest;
use App\Models\Contribuinte;
use App\Models\Protocolo;
use Auth;
use Inertia\Inertia;

class ContribuintesController extends Controller
{
    public function index()
    {
        $contribuintes = Contribuinte::withCount('protocolos')->get();

        return Inertia::render("Contribuintes/Index", ['contribuintes' => $contribuintes,]);
    }

    public function create()
    {
        return Inertia::render('Contribuintes/Create');
    }

    public function store(ContribuinteRequest $request)
    {
        $validated = $request->validated();

        $validated['cpf'] = str_replace( array( '.', '-' ), '', $request->input('cpf'));
    
        Contribuinte::create($validated);

        return to_route('contribuintes-index')->with('message', 'Contribuinte Cadastrado com Sucesso!');
    }
    
    public function show($id)
    {
        $contribuinte = Contribuinte::where('id', $id)->firstOrFail();

        $protocolos = Protocolo::whereBelongsTo($contribuinte)->orderBy('id', 'desc')->get();

        $total_prot = count($protocolos);

        $user = Auth::user();

        if(Auth::user()->perfil === 2) 
        {
            $departamentos = $user->departamentos()->pluck('departamento_id');

            $protocolos = Protocolo::whereIn('departamento_id', $departamentos)->whereBelongsTo($contribuinte)->orderBy('id', 'desc')->get();
        }
        
        $protocolos->load(['departamento:id,nome']);

        $protocolos->loadCount('acompanhamentos')->loadCount('anexos');

        return Inertia::render('Contribuintes/Show', [
            'contribuinte' => $contribuinte,
            'protocolos' => $protocolos,
            'total_prot' => $total_prot,
        ]);
    }

    public function edit($id)
    {
        $contribuinte = Contribuinte::where('id', $id)->firstOrFail();

        return Inertia::render('Contribuintes/Edit', ['contribuinte' => $contribuinte]);
    }

    public function update(ContribuinteRequest $request, $id)
    {
        $validated = $request->validated();

        $validated['cpf'] = str_replace( array( '.', '-' ), '', $request->input('cpf'));
        
        Contribuinte::find($id)->update($validated);

        return to_route('contribuintes-index')->with('message', 'Contribuinte Editado com Sucesso!');
    }

    public function destroy($id)
    {
        Contribuinte::find($id)->delete();

        return to_route('contribuintes-index');
    }
}
