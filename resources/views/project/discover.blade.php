<x-base>

    <h1>{{ __('Discover Projects') }}</h1>

    <form action="/discover" method="get" class="mb-5">
        <x-form-label for="search">{{ __('Search query') }}</x-form-label>
        <x-form-input id="search" name="q" required />

        <button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
    </form>

    <hr class="mb-5">

    {{ view('project.index', ['projects' => $projects]) }}

</x-base>
