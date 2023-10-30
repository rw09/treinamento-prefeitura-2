<?php

namespace App\Http\Controllers;


use App\Models\Departamento;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    // public function index(Request $request)
    // {
    //     $pesquisa = $request->get('pesquisa');

    //     $query = User::query();

    //     if ($pesquisa) {
    //         $query->where('name', 'like', "%{$pesquisa}%");
    //     }

    //     $users = $query->withCount('departamentos')->paginate(15)->withQueryString();

    //     //$users = User::all();
    //     //$users = User::withCount('departamentos')->get();
    //     //$users = User::withCount('departamentos')->paginate(15);
    //     //$users = User::with('departamentos')->get();
    //     //dd($users);

    //     return Inertia::render('Users/Index', [
    //         'users' => $users,
    //         'filters' => $request->only(['pesquisa'])
    //     ]);
    // }

    public function index()
    {
        $users = User::withCount('departamentos')->get();

        return Inertia::render('Users/Index', ['users' => $users]);
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|cpf|unique:users',
            'email' => 'required', 'email',
            'password' => 'required|min:6|max:15',
            'perfil' => 'required|in:0,1,2',
        ]);

        User::create($attributes);

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

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|cpf',
            'email' => 'required', 'email',
            // 'password' => 'required|min:6|max:15',
            'perfil' => 'required|in:0,1,2',
        ]);

        User::where('id', $id)->update($data);

        return to_route('users-index')->with('message', 'Usuário Editado com Sucesso!');
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->firstOrFail();

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

        //depois retornar?
    }

    public function removeDepartamento(Request $request, $id) //fazer a notificaçao de remover
    {
        $user = User::where('id', $request->user_id)->firstOrFail();

        $departamento = Departamento::where('id', $id)->firstOrFail();
        
        $user->departamentos()->detach($departamento);
        
        return redirect()->back();
    }
}
