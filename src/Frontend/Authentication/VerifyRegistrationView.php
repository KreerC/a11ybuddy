<?php

namespace A11yBuddy\Frontend\Authentication;

use A11yBuddy\Frontend\View;

class VerifyRegistrationView extends View
{

    public function isForAnonymousOnly(): bool
    {
        return true;
    }

    public function getPageTitle(): string
    {
        return 'Verify Registration';
    }

    public function render(array $data = []): void
    {
        if ($data["success"] === true) {
            ?>
            <h1>Thank you for verifying your e-mail address!</h1>
            <p>Your registration has been verified successfully. You can now log in to your account.</p>
            <a href="/login">Log In</a>
            <?php
        } else {
            ?>
            <h1>Registration Verification Failed</h1>
            <p>Your verification token seems to be invalid. Please try again or wait 24 hours to create a new account.</p>
            <?php
        }
    }

}