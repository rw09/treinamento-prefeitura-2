<?php

namespace App\Http\Controllers;

use App\Models\Contribuinte;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContribuintesController extends Controller
{
    public function index(Request $request)
    {
        //$contribuintes = Contribuinte::paginate(15);

        $pesquisa = $request->get('pesquisa');

        $query = Contribuinte::query();

        if ($pesquisa) {
            $query->where('nome', 'like', "%{$pesquisa}%");
        }

        $contribuintes = $query->paginate(15)->withQueryString();

        return Inertia::render('Contribuintes/Index', ['contribuintes' => $contribuintes]);
    }

    public function create()
    {
        return Inertia::render('Contribuintes/Create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'nome' => 'required|string|max:100',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|cpf|unique:contribuintes',
            'sexo' => 'required|in:F,M',
            'cidade' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'rua' => 'nullable|string|max:100',
            'numero' => 'nullable|integer',
            'complemento' => 'nullable|string|max:100',
        ]);
    
        Contribuinte::create($attributes);

        //return to_route('contribuintes-index')->with('message', 'Contribuinte Cadastrado com Sucesso!');
        return redirect(route('contribuintes-index')); //with message
    }
    
    public function edit($id)
    {
        $contribuinte = Contribuinte::where('id', $id)->firstOrFail();

        return Inertia::render('Contribuintes/Edit', ['contribuinte' => $contribuinte]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|cpf|',
            'sexo' => 'required|in:F,M',
            'cidade' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'rua' => 'nullable|string|max:100',
            'numero' => 'nullable|integer',
            'complemento' => 'nullable|string|max:100',
        ]);

        Contribuinte::where('id', $id)->update($data);

        return to_route('contribuintes-index');
    }

    public function destroy($id)
    {
        Contribuinte::where('id', $id)->delete();

        return to_route('contribuintes-index');
    }
}
