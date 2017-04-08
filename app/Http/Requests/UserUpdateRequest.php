<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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

    public function rules()
    {
        $id = $this->route('users');

        return [
            'name' => 'required|max:255',
            //'email' => "required|unique:people,name,$id|email",
            'tel' => 'required',
            'gender' => 'required',
            'dateBirth' => 'date_format:"d/m/Y"|required',
            'role' => 'required',
            'cpf' => 'required',
            'street' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'zipCode' => 'required',
            'state' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'tel' => 'telefone',
            'gender' => 'gênero',
            'dateBirth' => 'data de nascimento',
            'role' => 'cargo',
            'cpf' => 'CPF',
            'street' => 'logradouro',
            'neighborhood' => 'bairro',
            'city' => 'cidade',
            'zipCode' => 'CEP',
            'state' => 'UF',
            'password' => 'senha'
        ];
    }
}
