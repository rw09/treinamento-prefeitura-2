<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\Departamento;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::withCount('departamentos')->get();

        return Inertia::render('Users/Index', ['users' => $users]);
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();

        $validated['cpf'] = str_replace( array( '.', '-' ), '', $request->input('cpf'));
        
        User::create($validated);

        return to_route('users-index')->with('message', 'Usuário Cadastrado com Sucesso!');
    }

    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        if(Auth::user()->can('view', $user)) 
        {
            $user->load(['departamentos']);

            $departamentos = Departamento::get(['id', 'nome'])->diff($user['departamentos']);

            return Inertia::render('Users/Show', [
                'user' => $user,
                'departamentos'=> $departamentos
            ]); 
        }
        else
        {
            return redirect('/');
        }
    }
    

    public function edit($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        if(Auth::user()->can('update', $user)) //usar policies aqui? precisa?
        {
            return Inertia::render('Users/Edit', ['user' => $user]); 
        }
        else
        {
            return redirect('/');
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $validated = $request->validated();

        User::find($id)->update($validated);

        return to_route('users-index')->with('message', 'Usuário Editado com Sucesso!');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if(Auth::user()->can('delete', $user))
        {
            $user->delete();

            return to_route('users-index');
        }
        else
        {
            return redirect('/');
        }
    }

    public function addDepartamento(Request $request)
    {
        $user = User::where('id', $request->user_id)->firstOrFail();

        $departamento = Departamento::where('id', $request->departamento_id)->firstOrFail();

        $user->departamentos()->syncWithoutDetaching($departamento);

        //fazer a notificação
        //return redirect()->back()->with('message', '<b>ID:</b> ' . $user->id . '<br><b>Usuário:</b> ' . $user->name. '<br><b>E-mail:</b> ' . $user->email . '<br><b>CPF:</b> ' . $user->cpf);
    }

    public function removeDepartamento(Request $request, $id) //fazer a notificaçao de remover
    {
        $user = User::where('id', $request->user_id)->firstOrFail();

        $departamento = Departamento::where('id', $id)->firstOrFail();
        
        $user->departamentos()->detach($departamento);
        
        return redirect()->back();
    }
}
