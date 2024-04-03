<?php

namespace A11yBuddy\Frontend\Profile;

use A11yBuddy\Frontend\BasePage\NotFoundController;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\User\SessionManager;
use A11yBuddy\User\User;

/**
 * Shows the profile of a user
 */
class ProfileController extends Controller
{

    public function getPageTitle(): string
    {
        return 'Profile';
    }

    public function run(array $data = []): void
    {
        $user = $data["user"] ?? null;

        if ($user === null) {
            $user = User::getLoggedInUser();
        } else {
            $user = User::getByUsername($user);
        }

        if ($user === null) {
            NotFoundController::use();
            return;
        }

        ProfileView::use(array_merge($data, ["user" => $user]));
    }

}