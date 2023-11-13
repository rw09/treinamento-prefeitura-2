<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\Departamento;
use App\Models\User;
use Auth;
use Hash;
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
            $departamentos_usuario = $user->departamentos()->get();

            $departamentos_usuario->loadCount('users')->loadCount('protocolos');
            
            $user->load(['departamentos']); //trocar por $departamentos = $user->departamentos()->get() ?

            $departamentos = Departamento::get()->diff($user['departamentos']);

            $departamentos->loadCount('users')->loadCount('protocolos');

            return Inertia::render('Users/Show', [
                'user' => $user,
                'departamentos'=> $departamentos,
                'departamentos_usuario' => $departamentos_usuario,
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

        $validated['cpf'] = str_replace( array( '.', '-' ), '', $request->input('cpf'));
        
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

        return redirect()->back()->with('message', '<b>Acesso Concedido</b><br><b>Departamento: </b>' . $request->departamento_id . ' - ' . $departamento->nome . '<br><b>Usuário:</b> ' . $user->id . ' - ' . $user->name);
    }

    public function removeDepartamento(Request $request, $id)
    {
        $user = User::where('id', $request->user_id)->firstOrFail();

        $departamento = Departamento::where('id', $id)->firstOrFail();
        
        $user->departamentos()->detach($departamento);
        
        return redirect()->back()->with('message', '<b>Acesso Removido</b><br><b>Departamento: </b>' . $request->departamento_id . ' - ' . $departamento->nome . '<br><b>Usuário:</b> ' . $user->id . ' - ' . $user->name);
    }

    public function changePassword()
    {
        return Inertia::render('Users/ChangePassword');
    }

    public function updatePassword(UserPasswordUpdateRequest $request)
    {
        $validated = $request->validated();
        
        if(!Hash::check($validated['senha_velha'], auth()->user()->password))
        {
            return back()->with("message", "A senha atual está errada");
        } 


        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($validated['nova_senha'])
        ]);

        return redirect('/')->with('message', "Senha Alterada com Sucesso");
    }
}
