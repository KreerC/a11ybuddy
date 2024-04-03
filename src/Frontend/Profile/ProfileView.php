<?php

namespace A11yBuddy\Frontend\Profile;

use A11yBuddy\Frontend\Profile\ShowUserProjects;
use A11yBuddy\Frontend\View;
use Carbon\Carbon;

/**
 * Shows the profile of a user
 */
class ProfileView extends View
{

    public function render(array $data = []): void
    {
        /**
         * @var \A11yBuddy\User\User $user
         */
        $user = $data["user"];
        ?>
        <h1>Profile of
            <?= $user->getDisplayName() ?>
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

                    if ($user->isLoggedIn()) {
                        ?>
                    <p>
                        <b>Email:</b>
                        <?= $user->getEmail() ?>
                    </p>
                    <?php
                    }
                    ?>
            </div>
            <div class="col-lg-9">
                <h2>Projects</h2>
                <?php
                if ($user->isLoggedIn()) {
                    ?>
                    <a href="/create" class="btn btn-primary mb-5">
                        Create a new project
                    </a>
                    <?php
                }

                $projects = new ShowUserProjects();
                $projects->query($user->getId());
                ?>
            </div>
        </div>
        <?php
    }

}