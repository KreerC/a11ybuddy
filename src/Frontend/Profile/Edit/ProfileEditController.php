<?php

namespace A11yBuddy\Frontend\Profile\Edit;

use A11yBuddy\Frontend\Controller;
use A11yBuddy\Router;
use A11yBuddy\User\User;

/**
 * Allows the user to edit their profile
 */
class ProfileEditController extends Controller
{

    public function isForAuthenticatedOnly(): bool
    {
        return true;
    }

    public function getPageTitle(): string
    {
        return 'Edit Profile';
    }

    public function run(array $data = []): void
    {
        $user = User::getLoggedInUser();

        if (Router::getRequestMethod() === "POST") {

            if (
                isset($_POST["current_password"]) &&
                $user->checkPassword($_POST['current_password']) === false
            ) {
                ProfileEditView::use(["user" => $user, "error_message" => "You must enter your correct current password to make changes to your account."]);
                return;
            }

            $result = $user->setDisplayName($_POST["display_name"]);
            if ($result !== true) {
                ProfileEditView::use(["user" => $user, "error_message" => "Invalid display name."]);
                return;
            }

            $result = $user->setEmail($_POST["email"]);
            if ($result !== true) {
                ProfileEditView::use(["user" => $user, "error_message" => "Invalid e-mail address or e-mail already in use by another account."]);
                return;
            }

            if (isset($_POST["password"]) && $_POST["password"] !== "" && isset($_POST["password_confirm"]) && $_POST["password"] === $_POST["password_confirm"]) {
                $result = $user->setPassword($_POST["password"]);
                if ($result !== true) {
                    ProfileEditView::use(["user" => $user, "error_message" => "Invalid password, or password confirmation does not match."]);
                    return;
                }
            }

            $user->saveToDatabase();

            ProfileEditView::use(["user" => $user, "success_message" => "Profile updated successfully."]);
        } else {
            ProfileEditView::use(["user" => $user]);
        }
    }

}