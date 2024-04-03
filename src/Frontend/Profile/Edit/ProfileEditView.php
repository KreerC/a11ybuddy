<?php

namespace A11yBuddy\Frontend\Profile\Edit;

use A11yBuddy\Frontend\BasePage\ErrorView;
use A11yBuddy\Frontend\View;

/**
 * Allows the user to edit their profile
 */
class ProfileEditView extends View
{

    public function render(array $data = []): void
    {
        ErrorView::use($data);

        /**
         * @var \A11yBuddy\User\User $user
         */
        $user = $data["user"];

        ?>
        <h1>Edit your account details</h1>

        <form action="/profile/<?= $user->getUsername() ?>/edit" method="post">
            <div class="row">
                <div class="col-lg">
                    <div class="card mb-3">
                        <div class="card-header">
                            Update your account details
                        </div>

                        <div class="card-body">
                            <label class="form-label
            mb-3" for="display_name">Display name</label>

                            <input class="form-control mb-3" type="text" id="display_name" name="display_name"
                                value="<?= $user->getDisplayName() ?>">

                            <label class="form-label
            mb-3" for="email">Email address</label>

                            <input class="form-control mb-3" type="email" id="email" name="email"
                                value="<?= $user->getEmail() ?>">

                            <p>To change additional account details, please contact our support staff.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg">

                    <div class="card mb-3">
                        <div class="card-header">
                            Change your password
                        </div>

                        <div class="card-body">

                            <label class="form-label
            mb-3" for="password">New password</label>
                            <input type="password" class="form-control mb-3" id="password" name="password">

                            <label class="form-label
            mb-3" for="password_confirm">Confirm new password</label>
                            <input type="password" class="form-control mb-3" id="password_confirm" name="password_confirm">

                        </div>
                    </div>
                </div>

                <label class="form-label
            mb-3" for="current_password">Enter your current password to confirm changes</label>
                <input type="password" class="form-control mb-3" id="current_password" name="current_password">

                <button class="btn btn-primary" type="submit">Save Changes</button>
        </form>

        <a href="/profile" class="btn btn-secondary">Cancel</a>

        <p>You can also <a href="/profile/<?= $user->getUsername() ?>/delete">delete your account</a>.</p>
        <?php
    }
}