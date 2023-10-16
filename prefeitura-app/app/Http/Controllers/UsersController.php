<?php

namespace App\Http\Controllers;


use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        //$users = User::all();
        $users = User::withCount('departamentos')->get();
        //$users = User::with('departamentos')->get();
        //dd($users);

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
            'cpf' => 'required|cpf',
            'email' => 'required', 'email',
            'password' => 'required|min:6|max:15',
            'perfil' => 'required|in:0,1,2',
        ]);

        User::create($attributes);

        //return redirect('/');
        return to_route('users-index');
    }

    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        if(Auth::user()->can('view', $user)) 
        {
            return Inertia::render('Users/Show', ['user' => $user]); 
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

        //return Inertia::render('Users/Edit', ['user' => $user]);
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

        return to_route('users-index');
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
        
        //User::where('id', $id)->delete();
        //return to_route('users-index');
    }
}
