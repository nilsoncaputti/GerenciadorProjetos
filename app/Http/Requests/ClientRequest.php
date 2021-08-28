<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    //
    public function authorize()
    {
        return true;
    }

    //
    public function rules()
    {
        return [
            'nome' => ['required', 'min:2', 'max:100'],
            'endereco' => ['required', 'min:5', 'max:100']
        ];
    }
}
