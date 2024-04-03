<?php

namespace A11yBuddy\Frontend\Profile\Delete;

use A11yBuddy\Frontend\BasePage\NotFoundController;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\Logger;
use A11yBuddy\Router;
use A11yBuddy\User\SessionManager;
use A11yBuddy\User\User;

/**
 * Allows users to delete their account
 */
class ProfileDeleteController extends Controller
{

    public function isForAuthenticatedOnly(): bool
    {
        return true;
    }

    public function getPageTitle(): string
    {
        return 'Delete account';
    }

    public function run(array $data = []): void
    {
        $user = User::getByUsername($data["user"]);

        if ($user instanceof User === false) {
            NotFoundController::use();
            return;
        }

        if (Router::getRequestMethod() === "POST") {
            // Only the user themselves or an admin can delete the account
            if ($user->getId() === SessionManager::getLoggedInUserId() || SessionManager::isAdminSession()) {
                User::getDatabaseModel()->removeById($user->getId());
                Logger::info("User " . $user->getId() . " deleted their account");

                if (SessionManager::isAdminSession()) {
                    Router::redirect("/admin/users");
                } else {
                    Router::redirect("/logout");
                }
            } else {
                NotFoundController::use();
                return;
            }
        }

        ProfileDeleteView::use(["user" => $user]);
    }
}