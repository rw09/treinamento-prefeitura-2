<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AuditoriaController extends Controller
{
    public function index()
    {
        return Inertia::render('Auditoria/Index');
    }
}
