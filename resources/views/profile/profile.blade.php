<x-base>
    <h1 class="mb-5">{{ __('Profile of :name', ['name' => $user->display_name ?? $user->username]) }}
        @if ($user->verified === 1)
            <p class="badge text-bg-success">{{ __('Verified') }}</p>
        @endif
    </h1>

    <div class="row">

        <div class="col-md-4">
            <h2>{{ __('Account information') }}</h2>

            <p>
                <strong>{{ __('Username') }}:</strong> {{ $user->username }}
            </p>

            <p>
                <strong>{{ __('Display name') }}:</strong> {{ $user->display_name ?? $user->username }}
            </p>

            <p>
                <strong>{{ __('Joined') }}:</strong> {{ $user->created_at->diffForHumans() }}
            </p>

            @if ($user->is_admin or $user->id === auth()->id())
                <p>
                    <strong>{{ __('Email') }}:</strong> {{ $user->email }}
                </p>

                <a href="/profile/edit" class="btn btn-primary mt-5">{{ __('Edit profile') }}</a>
            @endif
        </div>

        <div class="col-md-6">
            <h2>{{ __('Projects') }}</h2>

            @if ($user->username === auth()->user()->username)
                <a href="/projects/create" class="btn btn-primary mb-5">{{ __('Create new project') }}</a>
            @endif

            {{ view('project.index', ['projects' => \App\Models\Project::where('user_id', $user->id)->orderBy('updated_at', 'desc')->with('user')->simplePaginate(25)]) }}
        </div>

</x-base>
