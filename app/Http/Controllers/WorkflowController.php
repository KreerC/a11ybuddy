<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkflowController extends Controller
{

    public function show(Project $project)
    {
        return view('project.workflow.create', ["project" => $project]);
    }

    public function validate()
    {
        return request()->validate([
            'name' => ['required', 'max:128'],
            'description' => ['required', 'max:255'],
        ]);
    }

    public function create(Project $project)
    {
        $attributes = $this->validate();

        $attributes['uuid'] = Str::uuid();
        $attributes['project_id'] = $project->id;

        Workflow::create($attributes);

        return redirect()->intended("/projects/{$project->slug}")->withErrors(['success' => 'Workflow created successfully!']);
    }

}
