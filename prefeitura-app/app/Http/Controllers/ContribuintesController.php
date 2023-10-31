<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContribuinteRequest;
use App\Models\Contribuinte;
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
    
        Contribuinte::create($validated);

        return to_route('contribuintes-index')->with('message', 'Contribuinte Cadastrado com Sucesso!');
    }
    
    public function edit($id)
    {
        $contribuinte = Contribuinte::where('id', $id)->firstOrFail();

        return Inertia::render('Contribuintes/Edit', ['contribuinte' => $contribuinte]);
    }

    public function update(ContribuinteRequest $request, $id)
    {
        $validated = $request->validated();

        Contribuinte::where('id', $id)->update($validated);

        return to_route('contribuintes-index')->with('message', 'Contribuinte Editado com Sucesso!');
    }

    public function destroy($id)
    {
        Contribuinte::where('id', $id)->delete();

        return to_route('contribuintes-index');
    }
}
