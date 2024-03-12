<?php

namespace A11yBuddy\User;

class SessionManager
{

    public function __construct()
    {
        session_start();
    }

    /**
     * Checks whether a user is logged in.
     * 
     * @return bool True if a user is logged in, false otherwise.
     */
    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

}