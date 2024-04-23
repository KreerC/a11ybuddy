<x-base title="Register account">
    <h1>{{ __('Register an account') }}</h1>

    <form action="/register" method="post">
        @csrf

        <x-form-label for="username">{{ __('Username') }}</x-form-label>
        <x-form-input id="username" name="username" :value="old('username')" required />
        <x-form-error name="username" />

        <x-form-label for="email">{{ __('Email address') }}</x-form-label>
        <x-form-input type="email" id="email" name="email" :value="old('email')" required />
        <x-form-error name="email" />

        <x-form-label for="password">{{ __('Password') }}</x-form-label>
        <x-form-input type="password" id="password" name="password" required />

        <x-form-label for="password">{{ __('Confirm password') }}</x-form-label>
        <x-form-input type="password" id="password_confirmation" name="password_confirmation" required />

        <button class="btn btn-primary" type="submit">{{ 'Sign up' }}</button>
    </form>
</x-base>
