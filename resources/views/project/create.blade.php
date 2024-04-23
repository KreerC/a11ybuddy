<x-base>
    <h1>{{ __('Create a new Project') }}</h1>
    <div class="row">
        <div class="col-lg-8">
            <form action="/projects" method="post">
                @csrf

                <x-form-label for="project-name">{{ __('Name') }}</x-form-label>
                <x-form-input id="name" name="name" :value="old('name')" required />
                <x-form-error name="name" />

                <x-form-label for="description">{{ __('Description') }}</x-form-label>
                <textarea class="form-control mb-3" id="description" name="description" rows="3" :value="old('description')"
                    required></textarea>
                <x-form-error name="description" />

                <x-form-label for="url">{{ __('URL') }}</x-form-label>
                <x-form-input type="url" id="url" name="url" :value="old('url')" required />
                <x-form-error name="url" />

                <x-form-label for="is_private">{{ __('Visibility') }}</x-form-label>
                <select class="form-select mb-3" id="is_private" name="is_private" :value="old('is_private')">
                    <option value="0">{{ __('Public') }}</option>
                    <option value="1">{{ __('Private') }}</option>
                </select>
                <x-form-error name="is_private" />

                <button class="btn btn-primary" type="submit">{{ __('Create Project') }}</button>
            </form>
        </div>
        <div class="col">
            {{ __('Create a new project to start tracking accessibility issues') }}
        </div>
    </div>
</x-base>
