<a href="#content" class="visually-hidden-focusable">
    {{ __('Skip to main content') }}
</a>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="/">
            a11yBuddy
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" :aria-label="__('Toggle navigation')">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="/discover">
                        {{ __('Discover') }}
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ __('Account') }}
                    </a>

                    @guest
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/login">
                                    {{ __('Log in') }}
                                </a></li>
                            <li><a class="dropdown-item" href="/register">
                                    {{ __('Register') }}
                                </a></li>
                        </ul>
                    @endguest

                    @auth
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/profile/{{ auth()->user()->username }}">
                                    {{ __('My projects') }}
                                </a></li>
                            <li>
                                <form action="/logout" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button class="dropdown-item" type="submit">
                                        {{ __('Log out') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @endauth

                </li>
            </ul>
        </div>
    </div>
</nav>
