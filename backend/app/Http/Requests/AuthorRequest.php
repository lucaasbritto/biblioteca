<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $authorId = $this->route('id') ?? null;

        return [
            'name' => 'required|max:40|unique:authors,Nome,' . $authorId . ',CodAu',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do autor é obrigatório.',
            'name.max' => 'O nome do autor não pode ter mais de 40 caracteres.',
            'name.unique' => 'Este autor já está cadastrado.',
        ];
    }
}
