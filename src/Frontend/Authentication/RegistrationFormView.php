<?php

namespace A11yBuddy\Frontend\Authentication;

use A11yBuddy\Frontend\BasePage\ErrorView;
use A11yBuddy\Frontend\View;

/**
 * Displays an account registration form
 */
class RegistrationFormView extends View
{

    public function render(array $data = []): void
    {
        ?>
        <h1>Register an account</h1>

        <?php ErrorView::use($data); ?>

        <?php
        if (isset ($data["registration_disabled"])) {
            return;
        }
        ?>

        <form action="/signup" method="post">
            <label class="form-label mb-3" for="username">Username</label>
            <input class="form-control mb-3" type="text" id="username" name="username" style="text-transform: lowercase"
                value="<?= htmlspecialchars($data["post"]["username"] ?? "") ?>" required>

            <label class=" form-label mb-3" for="email">Email address (will never be shared publicly)</label>
            <input class="form-control mb-3" type="email" id="email" name="email"
                value="<?= htmlspecialchars($data["post"]["email"] ?? "") ?>" required>

            <label class="form-label mb-3" for="display_name">Display name</label>
            <input class="form-control mb-3" type="text" id="display_name" name="display_name"
                value="<?= htmlspecialchars($data["post"]["display_name"] ?? "") ?>" required>

            <label class="form-label mb-3" for="password">Password</label>
            <input class="form-control mb-3" type="password" id="password" name="password" required>

            <label class="form-label mb-3" for="password_confirm">Confirm password</label>
            <input class="form-control mb-3" type="password" id="password_confirm" name="password_confirm" required>

            <button class="btn btn-primary" type="submit">Register</button>
        </form>

        <?php
    }

}