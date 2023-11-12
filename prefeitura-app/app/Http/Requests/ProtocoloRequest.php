<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProtocoloRequest extends FormRequest
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
            'contribuinte_id' => 'required|exists:contribuintes,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'descricao' => 'required|string',
            'prazo' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Campo obrigatório',
            // 'descricao.max' => 'Máximo 255 caracteres',
            'prazo.min' => 'Prazo inválido'
        ];
    }
}
