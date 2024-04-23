<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestStepController extends Controller
{

    public function show(Project $project, Workflow $workflow)
    {
        return view('project.workflow.step.create', [
            'project' => $project,
            'workflow' => $workflow
        ]);
    }

    public function validate()
    {
        return request()->validate([
            'name' => ['required', 'max:64'],
            'description' => ['required', 'max:1024'],
            'url' => ['url'],
        ]);
    }

    public function create(Project $project, Workflow $workflow)
    {
        $attributes = $this->validate();

        $attributes['uuid'] = Str::uuid();
        $attributes['workflow_id'] = $workflow->id;

        $workflow->testSteps()->create($attributes);

        $project->updated_at = now();
        $workflow->updated_at = now();
        $project->save();
        $workflow->save();

        return redirect()->intended("/projects/{$project->slug}")->withErrors(['success' => 'Test step created successfully!']);
    }

}
