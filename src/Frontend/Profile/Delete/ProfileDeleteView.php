<?php

namespace A11yBuddy\Frontend\Profile\Delete;

use A11yBuddy\Frontend\View;

class ProfileDeleteView extends View
{
    public function render(array $data = []): void
    {
        /**
         * @var \A11yBuddy\User\User $user
         */
        $user = $data["user"];

        ?>
        <h1>Delete account
            <i>
                <?= $user->getUsername() ?>
            </i>
        </h1>
        <p>Are you sure you want to delete your account? This action cannot be undone.</p>

        <form method="post">
            <button type="submit" class="btn btn-danger">Yes, delete the account now</button>
        </form>

        <a href="/profile/<?= $user->getUsername() ?>" class="btn btn-secondary">No, go back</a>
        <?php
    }
}