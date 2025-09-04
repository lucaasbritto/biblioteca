<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $subjectId = $this->route('id') ?? null;

        return [
            'name' => 'required|max:40|unique:subjects,Descricao,' . $subjectId . ',CodAs',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do assunto é obrigatório.',
            'name.max' => 'O nome do assunto não pode ter mais de 40 caracteres.',
            'name.unique' => 'Este assunto já está cadastrado.',
        ];
    }
}
