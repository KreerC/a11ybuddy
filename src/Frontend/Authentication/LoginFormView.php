<?php

namespace A11yBuddy\Frontend\Authentication;

use A11yBuddy\Frontend\BasePage\ErrorView;
use A11yBuddy\Frontend\View;

/**
 * Displays a login form
 */
class LoginFormView extends View
{

    public function render(array $data = []): void
    {
        ?>
        <h1>Login</h1>

        <?php ErrorView::use($data); ?>

        <p>Please enter your email and password to login.</p>

        <form action="/login" method="post">
            <label class="form-label mb-3" for="email">Email address</label>
            <input class="form-control mb-3" type="email" id="email" name="email" required>

            <label class="form-label mb-3" for="password">Password</label>
            <input class="form-control mb-3" type="password" id="password" name="password" required>

            <button class="btn btn-primary" type="submit">Log in</button>
        </form>

        <?php
    }

}