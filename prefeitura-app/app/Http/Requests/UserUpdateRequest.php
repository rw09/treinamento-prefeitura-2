<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'cpf' => ['required', 'cpf', Rule::unique('users')->ignore(request()->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore(request()->id)],
            // 'password' => 'required|min:6|max:15',
            'perfil' => 'required|in:0,1,2',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Campo obrigatório',
            'name.max' => 'Máximo 255 caracteres',
            'cpf.unique' => 'CPF já cadastrado',
            'cpf.cpf' => 'CPF inválido',
            // 'password.min' => 'A senha deve ter pelo menos 6 caracteres',
            // 'password.max' => 'A senha deve ter no máximo 15 caracteres',
            'email.unique' => 'Email já cadastrado',
            'email.email' => 'Email inválido',
        ];
    }
}
