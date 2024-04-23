<div class="col-lg-12">
    <div class="card mb-3" lang="{{ $project->language }}">
        <div class="card-body">
            <a href="/projects/{{ $project->slug }}">
                <h2 class="card-title">
                    <span class="text-muted">{{ $project->user->username }}/</span>
                    {{ $project->name }}
                </h2>
            </a>

            @if ($project->is_private)
                <span class="badge text-bg-secondary">
                    {{ __('Private') }}
                </span>
            @endif

            <p class="card-text">
                {{ $project->description ?? '<i>No description available</i>' }}
            </p>
        </div>
        <div class="card-footer">
            <span class="text-muted">
                {{ __('Updated :timeago', ['timeago' => $project->updated_at->diffForHumans()]) }}
            </span>

            <a href="/projects/{{ $project->slug }}" class="btn btn-primary float-right"
                aria-label="{{ __('View project :project by :username', ['project' => $project->name, 'username' => $project->user->username]) }}">
                {{ __('View project') }}
            </a>
        </div>
    </div>
</div>
