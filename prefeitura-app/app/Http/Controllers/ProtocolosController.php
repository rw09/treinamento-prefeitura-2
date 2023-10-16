<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Protocolo;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProtocolosController extends Controller
{
    public function index()
    {
        
        if(Auth::user()->perfil === 0) //admin da TI, tem acesso à todos os protocolos
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
}
