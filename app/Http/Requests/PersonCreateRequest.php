<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonCreateRequest extends FormRequest
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
            'tel' => 'required',
            'gender' => 'required',
            'dateBirth' => 'date_format:"d/m/Y"|required',
            'role_id' => 'required',
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
            'name' => 'Nome',
            'tel' => 'Telefone',
            'gender' => 'Gênero',
            'dateBirth' => 'Data de nascimento',
            'role_id' => 'Cargo',
            'street' => 'Logradouro',
            'neighborhood' => 'Bairro',
            'city' => 'Cidade',
            'zipCode' => 'CEP',
            'state' => 'UF',
        ];
    }
}
