<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContribuinteRequest;
use App\Models\Contribuinte;
use App\Models\Protocolo;
use Inertia\Inertia;

class ContribuintesController extends Controller
{
    public function index()
    {
        $contribuintes = Contribuinte::all();

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

        $protocolos->load(['departamento:id,nome']);

        //$protocolos->load(['acompanhamentos']);
        $protocolos->load(['acompanhamentos:id,observacao,created_at,protocolo_id']);

        return Inertia::render('Contribuintes/Show', [
            'contribuinte' => $contribuinte,
            'protocolos' => $protocolos,
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
        
        //Contribuinte::where('id', $id)->update($validated);
        Contribuinte::find($id)->update($validated);

        return to_route('contribuintes-index')->with('message', 'Contribuinte Editado com Sucesso!');
    }

    public function destroy($id)
    {
        //Contribuinte::where('id', $id)->delete();
        Contribuinte::find($id)->delete();

        return to_route('contribuintes-index');
    }
}
