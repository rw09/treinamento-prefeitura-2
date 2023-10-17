<?php

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContribuintesController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\ProtocolosController;
use App\Http\Controllers\UsersController;
use App\Models\Departamento;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');


Route::middleware('auth')->group(function () {
    
    //Teste pra ver os departamentos de cada usuário na home, depois colocar na pagina do perfil?
    Route::get('/', function () {
        return Inertia::render('Home', [
            'departamentos' => Auth::user()->perfil === 0 ?
            Departamento::all() : Auth::user()->departamentos()->get()
        ]);
    })->name('home');

    Route::prefix('contribuintes')->group(function () {
        Route::get('/', [ContribuintesController::class, 'index'])->name('contribuintes-index');
        Route::get('/create', [ContribuintesController::class, 'create'])->name('contribuintes-create');
        Route::post('/', [ContribuintesController::class, 'store'])->name('contribuintes-store');
        Route::get('/{id}/show', [ContribuintesController::class, 'show'])->where('id', '[0-9]+')->name('contribuintes-show');
        Route::get('/{id}/edit', [ContribuintesController::class, 'edit'])->where('id', '[0-9]+')->name('contribuintes-edit');
        Route::put('/{id}', [ContribuintesController::class, 'update'])->where('id', '[0-9]+')->name('contribuintes-update');
        Route::delete('/{id}', [ContribuintesController::class, 'destroy'])->where('id', '[0-9]+')->name('contribuintes-destroy');
    });

    Route::prefix('protocolos')->group(function () {
        Route::get('/', [ProtocolosController::class, 'index'])->name('protocolos-index');
        Route::get('/create', [ProtocolosController::class, 'create'])->name('protocolos-create');
        Route::post('/', [ProtocolosController::class, 'store'])->name('protocolos-store');
        Route::get('/{id}/show', [ProtocolosController::class, 'show'])->where('id', '[0-9]+')->name('protocolos-show');
        Route::get('/{id}/edit', [ProtocolosController::class, 'edit'])->where('id', '[0-9]+')->name('protocolos-edit');
        Route::put('/{id}', [ProtocolosController::class, 'update'])->where('id', '[0-9]+')->name('protocolos-update');
        Route::delete('/{id}', [ProtocolosController::class, 'destroy'])->where('id', '[0-9]+')->name('protocolos-destroy');
    });
    
    
    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('users-index')->can('viewAny', 'App\Models\User');
        Route::get('/create', [UsersController::class, 'create'])->name('users-create')->can('create', 'App\Models\User');
        Route::post('/', [UsersController::class, 'store'])->name('users-store');
        Route::get('/{id}/show', [UsersController::class, 'show'])->where('id', '[0-9]+')->name('users-show');
        Route::get('/{id}/edit', [UsersController::class, 'edit'])->where('id', '[0-9]+')->name('users-edit');
        Route::put('/{id}', [UsersController::class, 'update'])->where('id', '[0-9]+')->name('users-update');
        Route::delete('/{user}', [UsersController::class, 'destroy'])->where('id', '[0-9]+')->name('users-destroy');
    });


    Route::prefix('departamentos')->group(function () {
        Route::get('/', [DepartamentosController::class, 'index'])->name('departamentos-index')->can('viewAny', 'App\Models\Departamento');
        Route::get('/create', [DepartamentosController::class, 'create'])->name('departamentos-create')->can('create', 'App\Models\Departamento');
        Route::post('/', [DepartamentosController::class, 'store'])->name('departamentos-store');
        Route::get('/{id}/show', [DepartamentosController::class, 'show'])->where('id', '[0-9]+')->name('departamentos-show');
        Route::get('/{id}/edit', [DepartamentosController:: class, 'edit'])->where('id', '[0-9]+')->name('departamentos-edit');
        Route::put('/{id}', [DepartamentosController::class, 'update'])->where('id', '[0-9]+')->name('departamentos-update');
        Route::delete('/{id}', [DepartamentosController::class, 'destroy'])->where('id', '[0-9]+')->name('departamentos-destroy');
        Route::post('/add-user', [DepartamentosController::class, 'addUser'])->name('departamentos-add-user');
        Route::post('/remove-user/{id}', [DepartamentosController::class, 'removeUser'])->where('id', '[0-9]+')->name('departamentos-remove-user');
    });

    Route::prefix('auditoria')->group(function () {
        Route::get('/', [AuditoriaController::class, 'index'])->name('auditoria-index')->can('viewAny', 'App\Models\Auditoria');
    });

});


