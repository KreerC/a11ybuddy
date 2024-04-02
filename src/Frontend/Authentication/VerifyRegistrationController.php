<?php

namespace A11yBuddy\Frontend\Authentication;

use A11yBuddy\Application;
use A11yBuddy\Frontend\BasePage\NotFoundController;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\Logger;

class VerifyRegistrationController extends Controller
{

    public function isForAnonymousOnly(): bool
    {
        return true;
    }

    public function getPageTitle(): string
    {
        return 'Verify Registration';
    }

    public function run(array $data = []): void
    {
        $db = Application::getInstance()->getDatabase();

        $result = $db->query('SELECT * FROM registration_verification WHERE token = :token', [':token' => $data['token']]);
        $result = $result->fetch(\PDO::FETCH_ASSOC);

        $view = new VerifyRegistrationView();

        // If the token is not found, show an error message.
        if ($result === false) {
            $view->render(['success' => false]);
        } else {
            // If the token is found, update the user's status to verified.
            $db->query('UPDATE users SET status = 1 WHERE id = :id', [':id' => $result['user_id']]);
            // Delete the token from the database.
            $db->query('DELETE FROM registration_verification WHERE token = :token', [':token' => $data['token']]);
            Logger::info('User with ID ' . $result['user_id'] . ' has been verified');
            $view->render(['success' => true]);
        }
    }

}