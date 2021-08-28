<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $employees = Employee::paginate(15);

        return view('employees.index', [
            'employees' => $employees
        ]);
    }

    //
    public function create()
    {
        return view('employees.create');
    }

    //
    public function store(EmployeeRequest $request)
    {
        DB::transaction(function () use ($request) {
            $employee = Employee::create(
                $request->only(['nome', 'cpf', 'data_contratacao'])
            );

            $employee->address()->create(
                $request->only(['logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'cep', 'estado'])
            );
        });

        return redirect()->route('employees.index')
            ->with('mensagem', 'Funcionário cadastrado com sucesso!');
    }

    //
    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return view('employees.show', [
            'employee' => $employee
        ]);
    }

    //
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);

        return view('employees.edit', [
            'employee' => $employee
        ]);
    }

    //
    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);

        DB::transaction(function () use ($request, $employee) {
            $employee->update(
                $request->only(['nome', 'cpf', 'data_contratacao'])
            );

            $employee->address->update(
                $request->only(['logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'cep', 'estado'])
            );
        });

        return redirect()->route('employees.index')
            ->with('mensagem', 'Funcionário atualizado com sucesso!');
    }

    //
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        DB::transaction(function () use ($employee) {
            $employee->address->delete();

            $employee->delete();
        });

        return redirect()->route('employees.index')
            ->with('mensagem', 'Funcionário apagado com sucesso!');
    }
}
