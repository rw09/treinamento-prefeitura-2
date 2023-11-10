<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnexoRequest extends FormRequest
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
            'anexos' => 'array','max:5',
            'anexos.*' => 'mimes:jpg,jpeg,png,pdf|max:3072',
        ];
    }

    public function messages(): array //usar?
    {
        return [
            'anexos.max' => 'Máximo 5 arquivos',
            'anexos.*.mimes' => 'Formato arquivo inválido! Formatos aceitos: .jpg, .jpeg, .png, .pdf',
            'anexos.*max' => 'Tamanho arquivo inválido! No máximo 3MB por arquivo',
        ];
    }
}
