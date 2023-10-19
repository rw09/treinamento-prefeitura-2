<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartamentosController extends Controller
{
    public function index(Request $request)
    {
        $pesquisa = $request->get('pesquisa');

        $query = Departamento::query();

        if ($pesquisa) {
            $query->where('nome', 'like', "%{$pesquisa}%");
        }

        $departamentos = $query->withCount('users')->withCount('protocolos')->paginate(15)->withQueryString();

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
        $departamento = Departamento::where('id', $id)->firstOrFail();

        if(Auth::user()->can('view', $departamento)) 
        {
            $departamento->load(['users']);

            $departamento->load(['protocolos']);

            // $users = User::whereNotIn('id', User::select('users.id')
            //     ->join('departamento_user', 'users.id', '=', 'departamento_user.user_id')
            //     ->where('departamento_user.departamento_id', $departamento->id)
            // )->having('users.perfil', 2)->get();

            $users = User::where('perfil', 2)->get(['id', 'name'])->diff($departamento['users']);
            //$users = $users->diff($departamento['users']);
        
            return Inertia::render('Departamentos/Show', [
                'departamento' => $departamento,
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

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        Departamento::create($attributes);

        return to_route('departamentos-index');
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

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        Departamento::where('id', $id)->update($data);

        return to_route('departamentos-index');
    }

    public function destroy($id)
    {
        $departamento = Departamento::where('id', $id)->firstOrFail();

        if(Auth::user()->can('delete', $departamento))
        {
            $departamento->delete();
            return to_route('departamentos-index');
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

        //return Inertia::dialog('Departamentos/AddUser');
        //return to_route('departamentos-show', $departamento->id);
        //return redirect()->back();
        //return to_route('departamentos-index');
    }

    public function removeUser(Request $request, $id)
    {
        $departamento = Departamento::where('id', $request->departamento_id)->firstOrFail();
        
        $user = User::where('id', $id)->firstOrFail();

        $departamento->users()->detach($user);

        //return redirect()->back();
        //return to_route('departamentos-show', $departamento->id);
    }
}
