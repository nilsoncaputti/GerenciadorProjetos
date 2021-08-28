<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $employees = Employee::paginate(5);

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
    public function store(Request $request)
    {
        $dados = $request->except('_token');

        Employee::create($dados);

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
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->update(
            $request->except(['_token', '_method'])
        );

        return redirect()->route('employees.index')
            ->with('mensagem', 'Funcionário atualizado com sucesso!');
    }

    //
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('mensagem', 'Funcionário apagado com sucesso!');
    }
}
