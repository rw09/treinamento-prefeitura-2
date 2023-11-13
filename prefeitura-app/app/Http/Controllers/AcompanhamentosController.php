<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcompanhamentoRequest;
use App\Models\Acompanhamento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcompanhamentosController extends Controller
{
    public function edit($id)
    {
        $acompanhamento = Acompanhamento::find($id);

        return Inertia::render('Acompanhamentos/Edit', ['acompanhamento' => $acompanhamento]);
    }

    public function update(AcompanhamentoRequest $request, $id)
    {
        $validated = $request->validated();

        Acompanhamento::find($id)->update($validated);

        return to_route('protocolos-index')->with('message', 'Acompanhamento Editado com Sucesso!');
    }
}
