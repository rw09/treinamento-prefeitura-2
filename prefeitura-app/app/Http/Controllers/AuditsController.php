<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuditsController extends Controller
{
    public function index()
    {
        $audits = Audit::with("user")->get();

        return Inertia::render('Auditoria/Index', ['audits' => $audits]);
    }

    public function show($id)
    {
        $audit = Audit::find($id);

        $audit->load('user');
        
        return Inertia::render('Auditoria/Show', ['audit' => $audit]);
    }
}
