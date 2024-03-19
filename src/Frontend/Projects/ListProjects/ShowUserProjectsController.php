<?php

namespace A11yBuddy\Frontend\Projects\ListProjects;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Controller;

class ShowUserProjectsController extends Controller
{

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

        $view = new ShowListOfUserProjectsView();
        $view->render(["projects" => $projects]);
    }

}