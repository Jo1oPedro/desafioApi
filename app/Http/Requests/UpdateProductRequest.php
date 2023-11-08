<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
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
            "nome" => "nullable|string|min:2",
            "descricao" => "nullable|string|min:1",
            "preco" => "nullable|numeric",
            "quantidade" => "nullable|integer",
        ];
    }

    public function messages()
    {
        return [
            "string" => "O campo :attribute precisa ser uma string",
            "min" => "O campo :attribute precisa ter pelo menos :min caracteres",
            "numeric" => "Este :attribute precisa ser um valor real",
            "integer" => "Este :attribute precisa ser um valor inteiro",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'errors' => $validator->errors(),
            'message' => 'Falha ao atualizar o produto'
        ], 422);

        throw new HttpResponseException($response);
    }
}
