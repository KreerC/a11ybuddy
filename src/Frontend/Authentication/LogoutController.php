<?php

namespace A11yBuddy\Frontend\Authentication;

use A11yBuddy\Frontend\Controller;
use A11yBuddy\Logger;

/**
 * Logs the user out by destroying the session
 */
class LogoutController extends Controller
{

    public function isForAuthenticatedOnly(): bool
    {
        return true;
    }

    public function isNoFollow(): bool
    {
        return true;
    }

    public function run(array $data = []): void
    {
        Logger::debug('User with ID ' . $_SESSION["user_id"] . ' logged out');
        session_destroy();
        header('Location: /');
        exit();
    }

}