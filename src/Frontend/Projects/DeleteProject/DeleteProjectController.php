<?php

namespace A11yBuddy\Frontend\Projects\DeleteProject;

use A11yBuddy\Frontend\Controller;
use A11yBuddy\Frontend\Profile\ProfileController;
use A11yBuddy\Logger;
use A11yBuddy\Project\Project;
use A11yBuddy\Router;
use A11yBuddy\User\SessionManager;

class DeleteProjectController extends Controller
{

    public function isForAuthenticatedOnly(): bool
    {
        return true;
    }

    public function getPageTitle(): string
    {
        return 'Delete project';
    }

    public function run(array $data = []): void
    {
        if (Router::getRequestMethod() === 'POST') {
            $project = Project::getByTextIdentifier($data['id']);

            if ($project === null) {
                Router::redirect("/profile");
                return;
            }

            if ($project->getUserId() !== SessionManager::getLoggedInUserId()) {
                Router::redirect("/profile");
                return;
            }

            Logger::info("Deleting project " . $project->getId());
            Project::getDatabaseModel()->removeById($project->getId());

            $profile = new ProfileController();
            $profile->run(["user" => null, "success_message" => "Project '" . $project->getName() . "' deleted."]);
        } else {
            $project = Project::getByTextIdentifier($data['id']);

            if ($project === null) {
                Router::redirect("/profile");
                return;
            }

            DeleteProjectView::use(["project" => $project]);
        }
    }
}