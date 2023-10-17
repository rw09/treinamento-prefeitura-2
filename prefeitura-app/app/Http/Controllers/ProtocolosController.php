<?php

namespace App\Http\Controllers;

use App\Models\Contribuinte;
use App\Models\Departamento;
use App\Models\Protocolo;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProtocolosController extends Controller
{
    public function index()
    {
        
        if(Auth::user()->perfil === 0 || Auth::user()->perfil === 1) //admin da TI e do Sistema, tem acesso à todos os protocolos
        {
            $protocolos = Protocolo::all();
            $protocolos->load(['contribuinte']);
            $protocolos->load(['departamento']);
        }
        else
        {
            $user = Auth::user();
            $departamentos = $user->departamentos()->pluck('departamento_id');
            $protocolos = Protocolo::whereIn('departamento_id', $departamentos)
            ->with(['contribuinte'])
            ->with(['departamento'])
            ->get();
        }

        return Inertia::render('Protocolos/Index', ['protocolos' => $protocolos]);
    }

    public function create()
    {
        $departamentos = null;

        if(Auth::user()->perfil === 0 || Auth::user()->perfil === 1)
        {
            $departamentos = Departamento::all();    
        }
        else
        {
            $user = Auth::user();
            $departamentos = $user->departamentos()->get();
        }

        
        $contribuintes = Contribuinte::all();

        return Inertia::render('Protocolos/Create', [
            'departamentos' => $departamentos,
            'contribuintes' => $contribuintes,
        ]);
    }

    public function store(Request $request)
    {
        //dd($request);
        $attributes = $request->validate([
            'contribuinte_id' => 'required|exists:contribuintes,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'descricao' => 'required|string|max:255',
            'prazo' => 'required|integer',
        ]);

        //dd($attributes);

        // Protocolo::create([
        //     'descricao' => $request->descricao,
        //     'departamento_id' => $request->departamento,
        //     'prazo' => $request->prazo,
        //     'contribuinte_id' => $request->contribuinte
        // ]);

        Protocolo::create($attributes);

        //return redirect('/');
        return to_route('protocolos-index');
    }
}
