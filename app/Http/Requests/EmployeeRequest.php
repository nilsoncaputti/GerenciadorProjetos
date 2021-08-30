<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => ['required', 'min:2', 'max: 100', 'string'],
            'cpf' => ['required', 'size:11', 'string'],
            'data_contratacao' => ['required', 'string'],
            'logradouro' => ['required', 'min:2', 'max:255', 'string'],
            'numero' => ['required', 'max:20', 'string'],
            'bairro' => ['required', 'max:50', 'string'],
            'cidade' => ['required', 'max:50', 'string'],
            'complemento' => ['max:50', 'string'],
            'cep' => ['required', 'size:8', 'string'],
            'estado' => ['required', 'size:2', 'string']
        ];
    }

    public function validationData()
    {
        $dados = $this->all();

        $dados['cpf'] = limpa_mascara($dados['cpf']);
        $dados['cep'] = limpa_mascara($dados['cep']);
        $dados['data_contratacao'] = date_to_iso($dados['data_contratacao']);

        $this->replace($dados);

        return $dados;
    }
}
