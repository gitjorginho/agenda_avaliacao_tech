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
        
        if($this->route()->methods[0] == 'PUT' || $this->route()->methods[0] == 'PATCH'){
            return [
                "name" => "required|max:70",
                "email" => "required|email" ,
                "telephone" =>['required','regex:/^\(\d{2}\)\d{4,5}-\d{4}$/'],
                "message" => "required",
                "file"=> "mimes:pdf,doc,docx,odt,txt|max:500",
            ];    
        }

        return [
            "name" => "required|max:70",
            "email" => "required|email" ,
            "telephone" =>['required','regex:/^\(\d{2}\)\d{4,5}-\d{4}$/'],
            "message" => "required",
            "file"=> "required|mimes:pdf,doc,docx,odt,txt|max:500",
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Nome é um campo obrigatório',
            'name.max'=>'O campo nome deve ter menos de 70 caracteres',
            'email.required'=>'Email é um campo obrigatório',
            'email.email'=>'Email inválido',
            'telephone.required'=>'Telefone é um campo obrigatório',
            'telephone.regex'=>'Telefone inválido',
            'message.required'=>'Menssagem é um campo obrigatório',
            'file.required'=>'Nanhum arquivo foi anexado',
            'file.mimes'=>'O arquivo anexado deve ter a extensão: pdf,doc,docx,odt ou txt ',
            'file.max'=>'O Arquivo deve ter o tamanho maximo de 500k',

        ];
    }
}
