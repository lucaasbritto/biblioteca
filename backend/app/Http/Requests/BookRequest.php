<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Titulo' => 'required|string|max:255',
            'Editora' => 'nullable|string|max:255',
            'Edicao' => 'nullable|integer|min:1',
            'AnoPublicacao' => 'nullable|string|size:4',
            'autor' => 'required|array|min:1',
            'autor.*' => 'exists:authors,CodAu',
            'assunto' => 'required|array|min:1',
            'assunto.*' => 'exists:subjects,CodAs',
        ];
    }
}
