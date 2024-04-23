@props(['name'])

@error($name)
    <p class="text-danger">{{ $message }}</p>
@enderror
