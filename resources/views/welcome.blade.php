<x-base title="Home">
    @guest
        <h1>Welcome to a11yBuddy!</h1>

        <p>
            a11yBuddy is a web application that helps you make your websites more accessible to people with disabilities.
        </p>
    @endguest

    @auth
        <h1>Welcome, {{ auth()->user()->display_name ?? auth()->user()->username }}!</h1>
    @endauth
</x-base>
