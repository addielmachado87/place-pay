<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePayment extends FormRequest
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
            'name' => 'required|max:25',
            'surname' => 'required|max:25',
            'email'=>'email',
            'movile'=>'required|numeric',
            'document'=>'required|max:25',
            'document_type'=>'required|max:25',
            'address'=>'required|max:100',
            'city'=>'required|max:100',
            'country'=>'required|max:100',
            'total'=>'required|numeric',

        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nombre es obligatorio ',
            'surname.required'  => 'Apellido es obligatorio ',
            'email.email'  => 'Debe ser una direccion de correo valida',
            'movil.required'  => 'Movil es obligatorio ',
            'movil.numeric'  => 'Movil solo contiene  numeros',
            'document.required'  => 'Documento es obligatorio',
            'document_type.required'  => 'Tipo Documento es obligatorio',
            'address.required'  => 'Direccion es obligatorio',
            'city.required'  => 'Ciudad es obligatorio',
            'country.required'  => 'Pais es obligatorio',
            'total.required'  => 'Monto es obligatorio ',
            'total.numeric'  => 'Monto solo contiene  numeros',

        ];
    }
}
