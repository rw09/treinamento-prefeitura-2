<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartamentoRequest;
use App\Models\Departamento;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartamentosController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::withCount('users')->withCount('protocolos')->get();

        return Inertia::render('Departamentos/Index', [
            'departamentos' => $departamentos,
            'can' => [
                'viewAny' => Auth::user()->can('viewAny', Departamento::class),
                // 'view' => Auth::user()->can('view', Departamento::class),
                //'update' => Auth::user()->can('update', Departamento::class),
                //'delete' => Auth::user()->can('delete', Departamento::class),
            ]
        ]);
    }

    public function show($id)
    {
        $departamento = Departamento::where('id', $id)->with('users')->firstOrFail();

        if(Auth::user()->can('view', $departamento)) 
        {
            $protocolos = $departamento->protocolos()->with('contribuinte:id,nome')->get();

            $protocolos->loadCount('acompanhamentos')->loadCount('anexos');
            
            $users = User::where('perfil', 2)->get()->diff($departamento['users']);

            $departamento->loadCount('protocolos')->loadCount('users')->get();

            return Inertia::render('Departamentos/Show', [
                'departamento' => $departamento,
                'protocolos' => $protocolos,
                'users' => $users,
            ]);  
        }
        else
        {
            return redirect('/');
        }
    }

    public function create()
    {
        return Inertia::render('Departamentos/Create');
    }

    public function store(DepartamentoRequest $request)
    {
        $validated = $request->validated();

        Departamento::create($validated);

        return to_route('departamentos-index')->with('message', 'Departamento Cadastrado com Sucesso!');
    }

    public function edit($id)
    {
        $departamento = Departamento::where('id', $id)->firstOrFail();

        if(Auth::user()->can('update', $departamento)) //usar policies aqui? precisa?
        {
            return Inertia::render('Departamentos/Edit', ['departamento' => $departamento]); 
        }
        else
        {
            return redirect('/');
        }
    }

    public function update(DepartamentoRequest $request, $id)
    {
        $validated = $request->validated();

        Departamento::find($id)->update($validated);

        return to_route('departamentos-index')->with('message', 'Departamento Editado com Sucesso!');
    }

    public function destroy($id)
    {
        $departamento = Departamento::find($id);

        if(Auth::user()->can('delete', $departamento))
        {
            $departamento->delete();

            return redirect()->back();
        }
        else
        {
            return redirect('/');
        }
    }

    public function addUser(Request $request)
    {
        $departamento = Departamento::where('id', $request->departamento_id)->firstOrFail();

        $user = User::where('id', $request->user_id)->firstOrFail();

        $departamento->users()->syncWithoutDetaching($user);

        return redirect()->back()->with('message', '<b>ID:</b> ' . $user->id . '<br><b>Usuário:</b> ' . $user->name. '<br><b>E-mail:</b> ' . $user->email . '<br><b>CPF:</b> ' . $user->cpf);
    }

    public function removeUser(Request $request, $id)
    {
        $departamento = Departamento::where('id', $request->departamento_id)->firstOrFail();
        
        $user = User::where('id', $id)->firstOrFail();

        $departamento->users()->detach($user);

        return redirect()->back()->with('message', '<b>ID:</b> ' . $user->id . '<br><b>Usuário:</b> ' . $user->name. '<br><b>E-mail:</b> ' . $user->email . '<br><b>CPF:</b> ' . $user->cpf);
    }
}
