<?php

namespace App\Http\Requests;

use Hash;
use Illuminate\Foundation\Http\FormRequest;

class UserPasswordUpdateRequest extends FormRequest
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
            'senha_velha' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('A senha antiga fornecida não coincide com a senha atual.');
                    }
                },
            ],
            'nova_senha' => 'required|min:6|max:15',
            'confirmacao' => 'required|same:nova_senha'
        ];
    }


    public function messages(): array
    {
        return [
            'senha_velha' => 'Senha Incorreta',
            'required' => 'Campo Necessário',
            'min' => 'A senha deve ter pelo menos 6 caracteres',
            'max' => 'A senha deve ter no máximo 15 caracteres',
            'same' => 'As senhas não coincidem'
        ];
    }
}
