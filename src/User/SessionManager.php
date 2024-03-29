<?php

namespace A11yBuddy\User;

/**
 * Manages the user's session and provides methods for handling/checking the user's login status.
 */
class SessionManager
{

    public function __construct()
    {
        $this->renewSessionIdPeriodically();
    }

    /**
     * Renews the session ID and updates the session start time.
     */
    public function renewSessionId(): void
    {
        session_regenerate_id(true);
        $_SESSION['started'] = time();
    }

    /**
     * Security: Renews the session ID periodically for logged in users.
     * This behaviour is set to run every 15 minutes.
     */
    private function renewSessionIdPeriodically(): void
    {
        if ($this->isLoggedIn()) {
            if (isset($_SESSION['started']) && $_SESSION['started'] < time() - 60 * 15) {
                $this->renewSessionId();
            }
        }
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