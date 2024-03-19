<?php

namespace A11yBuddy\Frontend\Authentication;

use A11yBuddy\Frontend\Controller;

/**
 * Logs the user out by destroying the session
 */
class LogoutController extends Controller
{
    public function run(array $data = []): void
    {
        session_destroy();
        header('Location: /');
        exit();
    }

}