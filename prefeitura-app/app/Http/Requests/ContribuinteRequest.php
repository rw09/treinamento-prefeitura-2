<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContribuinteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:100',
            'data_nascimento' => 'required|date',
            'cpf' => ['required', 'cpf', Rule::unique('contribuintes')->ignore(request()->id)],
            'sexo' => 'required|in:F,M',
            'cidade' => ['nullable', 'string', 'max:100'],
            'bairro' => 'nullable|string|max:100',
            'rua' => 'nullable|string|max:100',
            'numero' => 'nullable|integer',
            'complemento' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Campo obrigatório',
            'max' => 'Máximo 100 caracteres',
            'cpf.unique' => 'CPF já cadastrado',
            'cpf.cpf' => 'CPF inválido',
        ];
    }
}
