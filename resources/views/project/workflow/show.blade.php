<div class="card mb-3" lang="{{ $project->language }}">
    <div class="card-body">
        <h3 class="card-title"> {{ $workflow->name }}</h3>

        <p class="card-text">
            {{ $workflow->description }}

            <hr class="mt-3 mb-3">

            {{ view('project.workflow.step.list', ['steps' => $workflow->testSteps, 'workflow' => $workflow, 'project' => $project]) }}
        </p>
    </div>

    @auth
        <div class="card-footer">
            <a href="/projects/{{ $project->slug }}/workflows/{{ $workflow->id }}/create" class="btn btn-primary">
                {{ __('Add a new step') }}
            </a>
        </div>
    @endauth

</div>
