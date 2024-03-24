<?php

namespace A11yBuddy\Frontend\Authentication;

use A11yBuddy\Frontend\Controller;
use A11yBuddy\User\User;
use A11yBuddy\User\UserStatus;

/**
 * Handles the login logic
 */
class LoginController extends Controller
{

    public function getPageTitle(): string
    {
        return 'Login';
    }

    public function isForAnonymousOnly(): bool
    {
        return true;
    }

    public function isNoFollow(): bool
    {
        return true;
    }

    public function run(array $data = []): void
    {
        if (isset ($_POST['email']) && isset ($_POST['password'])) {
            $user = User::getByEmail($_POST['email']);

            if ($user instanceof User) {
                if ($user->getStatus() === UserStatus::Unverified) {
                    $data['error_message'] = 'Your account has not been verified yet. Please check your e-mail for the verification link.';
                    LoginFormView::use($data);
                    return;
                }

                if ($user->checkPassword($_POST['password'])) {
                    // Log the user in
                    $_SESSION['user_id'] = $user->getId();
                    header('Location: /');
                    exit();
                }
            }

            $data['error_message'] = 'Invalid e-mail address or password.';
        }

        LoginFormView::use($data);
    }
}