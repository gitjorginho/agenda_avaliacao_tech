<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            "name" => "required|max:70",
            "age" => "required",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nome é um campo obrigatório',
            'name.max' => 'O campo nome deve ter menos de 70 caracteres',
            'age.required' => 'Idade é um campo obrigatório|numeric',
        ];
    }
}
