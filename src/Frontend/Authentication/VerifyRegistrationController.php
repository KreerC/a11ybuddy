<?php

namespace A11yBuddy\Frontend\Authentication;

use A11yBuddy\Application;
use A11yBuddy\Frontend\BasePage\NotFoundController;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\Logger;
use A11yBuddy\User\RegistrationVerification;
use A11yBuddy\User\User;
use A11yBuddy\User\UserStatus;

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
        $view = new VerifyRegistrationView();
        $verification = RegistrationVerification::getByToken($data["token"]);

        if ($verification instanceof RegistrationVerification) {
            // Verify the corresponding user. This causes many additional queries to the database,
            // so in the future we should consider simplifying this.
            $user = User::getById($verification->getUserId());
            if ($user instanceof User) {
                $user->setStatus(UserStatus::Verified);
                $user->saveToDatabase();

                RegistrationVerification::getDatabaseModel()->removeById($verification->getId());
                Logger::info('User with ID ' . $user->getId() . ' has been verified');
                $view->render(['success' => true]);
                return;
            }
        }

        $view->render(['success' => false]);
    }

}