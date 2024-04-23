<x-base>

    <h1>Create a new step</h1>

    <form action="/projects/{{ $project->slug }}/workflows/{{ $workflow->uuid }}/create" method="post">
        @csrf

        <x-form-label for="name">{{ __('Name') }}</x-form-label>
        <x-form-input id="name" name="name" :value="old('name')" required />
        <x-form-error name="name" />

        <x-form-label for="description">{{ __('Description') }}</x-form-label>
        <x-form-input id="description" name="description" :value="old('description')" required />
        <x-form-error name="description" />

        <button class="btn btn-primary" type="submit">{{ __('Create workflow') }}</button>
    </form>

</x-base>
