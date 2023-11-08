<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            "nome" => "required|string|min:2",
            "descricao" => "required|string|min:1",
            "preco" => "required|float",
            "quantidade" => "required|integer",
        ];
    }

    public function messages()
    {
        return [
            "required" => "O campo :attribute é obrigatório",
            "string" => "O campo :attribute precisa ser uma string",
            "min" => "O campo :attribute precisa ter pelo menos :min caracteres",
            "float" => "Este :attribute precisa ser um valor real",
            "integer" => "Este :attribute precisa ser um valor inteiro",
        ];
    }
}
