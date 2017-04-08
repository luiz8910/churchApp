<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|exists:users|email',
            'tel' => 'required',
            'gender' => 'required',
            'dateBirth' => 'date_format:"d/m/Y"|required',
            'occupation' => 'required',
            'cpf' => 'required',
            'street' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'zipCode' => 'required',
            'state' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'tel' => 'telefone',
            'gender' => 'gênero',
            'dateBirth' => 'data de nascimento',
            'occupation' => 'cargo',
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
