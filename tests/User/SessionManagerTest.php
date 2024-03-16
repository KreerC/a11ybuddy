<?php

use PHPUnit\Framework\TestCase;
use A11yBuddy\User\SessionManager;

class SessionManagerTest extends TestCase
{
    public function testAutomaticSessionRenewalWhenLoggedIn(): void
    {
        session_start();
        // Log in a user
        $_SESSION["user_id"] = 1;
        $_SESSION["started"] = time();
        $sessionId = session_id();

        new SessionManager();

        // Verify that the session has not been renewed yet
        $this->assertEquals(session_id(), $sessionId);

        // Simulate 16 minutes passing
        $_SESSION["started"] = time() - 60 * 16;
        new SessionManager();

        // Verify that the session has been renewed
        $this->assertNotEquals(session_id(), $sessionId);

        session_destroy();
    }

    public function testAutomaticSessionRenewalWhenLoggedOut(): void
    {
        session_start();
        $sessionId = session_id();

        new SessionManager();

        // Verify that the session has not been renewed automatically
        $this->assertEquals(session_id(), $sessionId);

        // Simulate 16 minutes passing
        $_SESSION["started"] = time() - 60 * 16;
        new SessionManager();

        // Verify that the session has not been renewed
        $this->assertEquals(session_id(), $sessionId);

        session_destroy();
    }

    public function testIsLoggedIn(): void
    {
        session_start();
        $sessionManager = new SessionManager();

        // Test when the user is not logged in
        $this->assertFalse($sessionManager->isLoggedIn());

        // Test when the user is logged in
        $_SESSION["user_id"] = 1;
        $this->assertTrue($sessionManager->isLoggedIn());

        session_destroy();
    }

    public function testRenewSessionId(): void
    {
        session_start();
        $sessionManager = new SessionManager();

        $sessionId = session_id();
        $sessionManager->renewSessionId();
        $this->assertNotEquals(session_id(), $sessionId);

        session_destroy();
    }

}