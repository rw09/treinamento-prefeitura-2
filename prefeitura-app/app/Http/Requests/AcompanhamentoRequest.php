<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcompanhamentoRequest extends FormRequest
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
            'observacao' => 'required|string',
            'protocolo_id' => 'required|exists:protocolos,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Campo obrigatório',
        ];
    }
}
