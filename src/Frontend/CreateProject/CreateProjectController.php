<?php

namespace A11yBuddy\Frontend\CreateProject;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Controller;

class CreateProjectController extends Controller
{

    public function getPageTitle(): string
    {
        return 'Create a new project';
    }

    public function run(array $data = []): void
    {
        // TODO

        // Display the view with an error message for the time being
        $view = new CreateProjectView();

        $errors = [];
        if (Application::getInstance()->getBasePageRenderer()->getRouter()->getRequestMethod() === 'POST') {
            $errors["warning_message"] = 'This feature is not yet implemented. Please try again later.';
        }

        $view->render($errors);
    }

}