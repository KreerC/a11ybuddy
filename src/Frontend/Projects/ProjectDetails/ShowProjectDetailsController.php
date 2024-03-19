<?php

namespace A11yBuddy\Frontend\Projects\ProjectDetails;

use A11yBuddy\Frontend\BasePage\NotFoundController;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\Project\Project;

/**
 * Shows details of a project
 */
class ShowProjectDetailsController extends Controller
{

    public function getPageTitle(): string
    {
        return 'Project details';
    }

    public function run(array $data = []): void
    {
        $project = Project::getByTextIdentifier($data["id"]);
        if ($project === null) {
            $notFoundController = new NotFoundController();
            $notFoundController->run();
            return;
        }

        ShowProjectDetailsView::use(["project" => $project]);
    }
}