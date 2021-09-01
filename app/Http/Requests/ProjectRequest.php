<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => ['required', 'string', 'min:2', 'max:100'],
            'orcamento' => ['required', 'numeric', 'min:0'],
            'data_inicio' => ['required', 'date_format:d/m/Y'],
            'data_final' => ['required', 'date_format:d/m/Y'],
            'client_id' => ['required', 'int'],
            'funcionarios' => ['required', 'array']
        ];
    }

    public function validationData()
    {
        $dados = $this->all();

        //$dados['data_inicio'] = date_to_iso($dados['data_inicio']);
        //$dados['data_final'] = date_to_iso($dados['data_final']);
        $dados['orcamento'] = str_replace(['.', ','], ['', '.'], $dados['orcamento']);

        $this->replace($dados);

        return $dados;
    }

    protected function getValidatorInstance()
    {
        $request = $this;

        return parent::getValidatorInstance()->after(function (Validator $v) use ($request) {
            if ($v->errors()->isEmpty()) {
                $dados = $request->all();

                $dados['data_inicio'] = date_to_iso($dados['data_inicio']);
                $dados['data_final'] = date_to_iso($dados['data_final']);

                $request->replace($dados);
            }
        });
    }
}
