<?php

namespace A11yBuddy\Frontend\Projects\ProjectDetails;

use A11yBuddy\Frontend\BasePage\NotFoundController;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\Project\Project;
use A11yBuddy\Project\ProjectStatus;
use A11yBuddy\User\SessionManager;

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
            NotFoundController::use();
            return;
        }

        // Authorized users can see their own private projects, and admins can see all projects
        if ($project->getStatus() !== ProjectStatus::Public ) {
            if ($project->getUserId() !== SessionManager::getLoggedInUserId() && !SessionManager::isAdminSession()) {
                NotFoundController::use();
                return;
            }
        }

        ShowProjectDetailsView::use(["project" => $project]);
    }
}