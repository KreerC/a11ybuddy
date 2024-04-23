<x-base>

    <h1>{{ $project->name }}</h1>

    <p>
        {{ $project->description ?? '<i>No description provided.</i>' }}
    </p>

    <hr class="mt-5 mb-5">

    <div class="row">
        <div class="col-md-4">
            <h2>{{ __('Project details') }}</h2>

            <p>
                <strong>{{ __('URL') }}:</strong>
                <a href="{{ $project->url }}" target="_blank">{{ $project->url }}</a>
            </p>

            <p>
                <strong>{{ __('Created by') }}:</strong>
                <a
                    href="/profile/{{ $project->user->username }}">{{ $project->user->display_name ?? $project->user->username }}</a>

            <p>
                <strong>{{ __('Visibility') }}:</strong>
                {{ $project->is_private ? __('Private') : __('Public') }}
            </p>

            <p>
                {{ __('Created :timeago', ['timeago' => $project->created_at->diffForHumans()]) }}
            </p>

            <p>
                {{ __('Updated :timeago', ['timeago' => $project->updated_at->diffForHumans()]) }}
            </p>

            @auth
                @if ($project->user->id === auth()->id() or auth()->user()->is_admin)
                    <form action="/projects/{{ $project->slug }}" method="post">
                        @csrf
                        @method('delete')

                        <button class="btn btn-danger" type="submit">{{ __('Delete project') }}</button>
                    </form>
                @endif
            @endauth

        </div>
        <div class="col-md-6">
            <h2>{{ __('Workflows') }}</h2>

            @auth
                <a href="/projects/{{ $project->slug }}/create"
                    class="btn btn-primary mb-5">{{ __('Create new workflow') }}</a>
            @endauth

            @foreach ($project->workflows as $workflow)
                {{ view('project.workflow.show', ['project' => $project, 'workflow' => $workflow]) }}
            @endforeach

        </div>
    </div>

</x-base>
