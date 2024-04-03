<?php

namespace A11yBuddy\Frontend\Profile;

use A11yBuddy\Frontend\BasePage\ErrorView;
use A11yBuddy\Frontend\Profile\ShowUserProjects;
use A11yBuddy\Frontend\View;
use A11yBuddy\User\SessionManager;
use A11yBuddy\User\UserStatus;
use Carbon\Carbon;

/**
 * Shows the profile of a user
 */
class ProfileView extends View
{

    public function render(array $data = []): void
    {
        ErrorView::use($data);

        /**
         * @var \A11yBuddy\User\User $user
         */
        $user = $data["user"];
        ?>
        <h1>Profile of
            <?php
            echo $user->getDisplayName();

            if ($user->isVerified()) {
                ?>
                <span aria-label="Verified account" title="Verified account">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </span>
                <?php
            }
            ?>
        </h1>

        <div class="row">
            <div class="col-lg-3">
                <h2>Profile details</h2>
                <p>
                    <b>Username:</b>
                    <?= $user->getUsername() ?>
                </p>

                <p>
                    <b>Account created:</b>
                    <?php
                    $time = Carbon::createFromTimestamp($user->getCreatedAt(), "Europe/Berlin");
                    echo $time->diffForHumans();
                    ?>
                </p>

                <?php
                if ($user->getStatus() === UserStatus::Privileged) {
                    ?>
                    <p><b>This account is an administrator.</b></p>
                    <?php
                }

                if ($user->isVerified()) {
                    ?>
                    <p><b>The owner of this account has been verified by staff.</b></p>
                    <?php
                }

                if ($user->isLoggedIn()) {
                    ?>
                    <p>
                        <b>Email (only you can see this):</b>
                        <?= $user->getEmail() ?>
                    </p>

                    <div class="btn-group-vertical d-block mt-5 mb-5" role="group">
                        <a href="/create" class="btn btn-secondary btn-outline-light">
                            Create a new project
                        </a>
                        <a href="/profile/<?= $user->getUsername() ?>/edit" class="btn btn-secondary btn-outline-light">
                            Edit profile
                        </a>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (SessionManager::isAdminSession()) {
                    ?>
                    <h3>Admin actions</h3>
                    <a href="/profile/<?= $user->getUsername() ?>/delete" class="btn btn-danger">
                        Delete account
                    </a>
                    <?php
                }
                ?>
            </div>
            <div class="col-lg-9">
                <h2>Projects</h2>
                <?php
                $projects = new ShowUserProjects();
                $projects->query($user->getId());
                ?>
            </div>
        </div>
        <?php
    }

}