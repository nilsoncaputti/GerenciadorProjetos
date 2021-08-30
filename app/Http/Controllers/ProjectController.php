<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        //dd($request->all());
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
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
