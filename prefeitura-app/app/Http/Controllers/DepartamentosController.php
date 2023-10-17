<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartamentosController extends Controller
{
    public function index()
    {
        // return Inertia::render('Departamentos/Index',
        //     ['can' => [
        //         Auth::user()->cpf === '318.387.580-20'
        //         ]
        //     ]);
        
        //$departamentos = Departamento::all();
        $departamentos = Departamento::withCount('users')->withCount('protocolos')->get();

        //$departamentos->load(['users']);

        //$departamentos->load(['protocolos']);
        //dd($departamentos);

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

            $users = User::whereNotIn('id', User::select('users.id')
                ->join('departamento_user', 'users.id', '=', 'departamento_user.user_id')
                ->where('departamento_user.departamento_id', $departamento->id)
            )->having('users.perfil', 2)->get();

            //dd($users);
        
            return Inertia::render('Departamentos/Show', [
                'departamento' => $departamento,
                'users' => $users,
            ]);  
        }
        else
        {
            return redirect('/');
        }
        //dd($departamento);
        //return Inertia::render('Departamentos/Show', ['departamento' => $departamento]);


    }

    public function create()
    {
        return Inertia::render('Departamentos/Create');
    }

    public function store(Request $request)
    {
        //dd($request);
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

        //return Inertia::render('Departamentos/Edit', ['departamento' => $departamento]);
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
        
        //Departamento::where('id', $id)->delete();
        //return to_route('departamentos-index');
    }

    public function addUser(Request $request)
    {
        //dd($request);

        $departamento = Departamento::where('id', $request->departamento_id)->firstOrFail();
        $user = User::where('id', $request->user_id)->firstOrFail();

        $departamento->users()->syncWithoutDetaching($user);
        //return Inertia::dialog('Departamentos/AddUser');

        //return to_route('departamentos-show', $departamento->id);
        //return redirect()->back();
    }

    public function removeUser(Request $request, $id)
    {
        //dd($request);
        //dd($id);

        //return 'USER ID' . $id . ' Depto ID ' . $request->departamento_id;
        $departamento = Departamento::where('id', $request->departamento_id)->firstOrFail();
        
        $user = User::where('id', $id)->firstOrFail();
        //dd($user);
        $departamento->users()->detach($user);
        //return redirect()->back();
        //return to_route('departamentos-show', $departamento->id);
    }
}
