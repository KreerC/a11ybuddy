<x-base>

    <h1>Create Test</h1>

    <form method="POST" action="#">
        @csrf

        <x-form-label for="catalog">Test Catalog</x-form-label>
        <select class="form-control mb-3" name="catalog">
            @foreach (\App\TestCatalog\TestCatalog::getAllCatalogs() as $id => $catalog)
                <option value="{{ $id }}">{{ $catalog->name }}</option>
            @endforeach
        </select>
        <x-form-error name="catalog" />

        <button type="submit" class="btn btn-primary">Create</button>

    </form>

</x-base>
