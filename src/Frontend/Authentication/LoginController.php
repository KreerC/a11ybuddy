<?php

namespace A11yBuddy\Frontend\Authentication;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\User\User;

/**
 * Handles the login logic
 */
class LoginController extends Controller
{
    public function getPageTitle(): string
    {
        return 'Login';
    }

    public function run(array $data = []): void
    {
        // Check whether we have a POST request
        if (Application::getInstance()->getBasePageRenderer()->getRouter()->getRequestMethod() === 'POST') {
            // See if username and password are present
            if (isset ($_POST['email']) && isset ($_POST['password'])) {
                // Run the query to get the user
                $user = User::getByEmail($_POST['email']);

                if ($user instanceof User) {
                    if ($user->checkPassword($_POST['password'])) {
                        // Log the user in
                        $_SESSION['user_id'] = $user->getId();
                        header('Location: /');
                        exit();
                    }
                }

                $data['error_message'] = 'Invalid e-mail address or password.';
            }
        }

        LoginFormView::use($data);
    }
}