<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('client')->get();

        return view('projects.index', [
            'projects' => $projects
        ]);
    }

    public function create()
    {
        $clientes = Client::get();
        $funcionarios = Employee::get();

        return view('projects.create', [
            'clientes' => $clientes,
            'funcionarios' => $funcionarios
        ]);
    }

    public function store(ProjectRequest $request)
    {
        DB::transaction(function () use ($request) {
            $project = project::create(
                $request->except(['_token', 'funcionarios'])
            );

            $project->employees()->attach($request->funcionarios);
        });

        return redirect()->route('projects.index')
            ->with('mensagem', 'Projeto criado com sucesso!');
    }

    public function show(Project $project)
    {
        $project->load(['client', 'employees']);

        return view('projects.show', [
            'project' => $project
        ]);
    }

    public function edit($id)
    {
        $projeto = Project::findOrFail($id);
        $clientes = Client::get();
        $funcionarios = Employee::get();

        return view('projects.edit', [
            'project' => $projeto,
            'clientes' => $clientes,
            'funcionarios' => $funcionarios
        ]);
    }

    public function update(ProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);

        DB::transaction(function () use ($request, $project) {
            $project->update(
                $request->except(['_token', 'funcionarios'])
            );

            $project->employees()->sync($request->funcionarios);
        });

        return redirect()->route('projects.index')
            ->with('mensagem', 'Projeto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        //
    }
}
