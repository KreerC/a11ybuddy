<?php

namespace A11yBuddy\Frontend\Authentication;

use A11yBuddy\Application;
use A11yBuddy\Frontend\BasePage\NotFoundController;
use A11yBuddy\Frontend\Controller;

class VerifyRegistrationController extends Controller
{

    public function run(array $data = []): void
    {
        $db = Application::getInstance()->getDatabase();

        $result = $db->query('SELECT * FROM registration_verification WHERE token = :token', [':token' => $data['token']]);

        $result = $result->fetch(\PDO::FETCH_ASSOC);

        // If the token is not found, show an error message.
        if ($result === false) {
            $nf = new NotFoundController();
            $nf->run();
        } else {
            // If the token is found, update the user's status to verified.
            $db->query('UPDATE users SET status = 1 WHERE id = :id', [':id' => $result['user_id']]);
            // Delete the token from the database.
            $db->query('DELETE FROM registration_verification WHERE token = :token', [':token' => $data['token']]);
            ?>
            <h1>Registration Verified</h1>
            <p>Your registration has been verified. You can now log in to your account.</p>
            <a href="/login">Log In</a>
            <?php
        }
    }

}