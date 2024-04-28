<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    public function show(Project $project)
    {
        $project->load('workflows', 'workflows.testSteps', 'user');
        return view('project.show', ["project" => $project]);
    }

    public function index()
    {
        return redirect()->intended("/discover");
    }

    public function discover()
    {
        if (request()->input('q')) {
            $projects = Project::where('name', 'like', '%' . request()->input('q') . '%', 'and', 'is_private', false)->with("user")->simplePaginate(15);
        } else {
            $projects = Project::where('is_private', false)->orderBy('updated_at', 'desc')->with("user")->simplePaginate(15);
        }
        return view('project.discover', ["projects" => $projects]);
    }

    public function validate()
    {
        return request()->validate([
            'name' => ['required', 'max:64'],
            'description' => ['required', 'max:1024'],
            'url' => ['required', 'url'],
            'is_private' => ['boolean'],
        ]);
    }

    public function create()
    {
        $attributes = $this->validate();

        // Create a unique slug
        $slug = Str::limit(Str::slug($attributes['name']), 16, '');
        while (Project::where('slug', $slug)->exists()) {
            $slug = Str::limit(Str::slug($attributes['name']), 16, '') . '-' . Str::random(5);
        }

        $attributes['slug'] = $slug;
        $attributes['user_id'] = auth()->id();

        Project::create($attributes);

        return redirect()->intended("/projects/{$slug}")->withErrors(['success' => 'Project created successfully!']);
    }

    public function destroy(Project $project)
    {
        Gate::authorize('delete', $project);

        $project->delete();
        return redirect()->intended("/profile/" . $project->user->username)->withErrors(['success' => 'Project deleted successfully!']);
    }

}
