<?php

namespace A11yBuddy\Frontend\Projects\ListProjects;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\Project\Project;
use A11yBuddy\User\SessionManager;
use A11yBuddy\User\User;

/**
 * Shows a list of projects for the logged in user
 */
class ShowUserProjectsController extends Controller
{

    public function isForAuthenticatedOnly(): bool
    {
        return true;
    }

    public function getPageTitle(): string
    {
        return 'Your projects';
    }

    public function run(array $data = []): void
    {
        $db = Application::getInstance()->getDatabase();
        $query = $db->query("SELECT projects.*, users.username FROM projects JOIN users ON projects.user_id = users.id WHERE user_id = :user_id", [":user_id" => SessionManager::getLoggedInUserId()]);
        $projects = $query->fetchAll(\PDO::FETCH_ASSOC);

        UserProjectView::use(["projects" => $projects]);
    }

}