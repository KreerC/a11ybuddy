<?php

namespace A11yBuddy\Frontend\CreateProject;

use A11yBuddy\Frontend\Controller;

class CreateProjectController implements Controller
{

    public function run(array $data = [])
    {
        // TODO

        // Return the view with an error message for the time being
        return CreateProjectView::render([
            'error' => 'This feature is not yet implemented'
        ]);
    }

}