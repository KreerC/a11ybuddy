<x-base title="Login">
    <h1>{{ __('Log in') }}</h1>

    <p>{{ __('Please enter your email and password to login.') }}</p>

    <form action="/login" method="post">
        @csrf

        <x-form-label for="email">{{ __('Email address') }}</x-form-label>
        <x-form-input type="email" id="email" name="email" :value="old('email')" required />
        <x-form-error name="email" />

        <x-form-label class="form-label mb-3" for="password">{{ __('Password') }}</x-form-label>
        <x-form-input class="form-control mb-3" type="password" id="password" name="password" required />

        <button class="btn btn-primary" type="submit">{{ __('Log in') }}</button>
    </form>
</x-base>
