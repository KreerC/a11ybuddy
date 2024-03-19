<?php

namespace A11yBuddy\Frontend\Projects\ListProjects;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Controller;

/**
 * Shows a list of projects for the logged in user
 */
class ShowUserProjectsController extends Controller
{

    public function getPageTitle(): string
    {
        return 'Your projects';
    }

    public function run(array $data = []): void
    {
        // Make sure the user is logged in
        if (Application::getInstance()->getSessionManager()->isLoggedIn() === false) {
            header('Location: /');
            exit();
        }

        $db = Application::getInstance()->getDatabase();
        $query = $db->query("SELECT * FROM projects WHERE user_id = :user_id", [":user_id" => $_SESSION['user_id']]);

        $projects = $query->fetchAll(\PDO::FETCH_ASSOC);

        ShowListOfUserProjectsView::use(["projects" => $projects]);
    }

}