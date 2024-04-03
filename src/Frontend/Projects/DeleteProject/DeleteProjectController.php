<?php

namespace A11yBuddy\Frontend\Projects\DeleteProject;

use A11yBuddy\Frontend\BasePage\NotFoundController;
use A11yBuddy\Frontend\Controller;
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
            $notFoundController = new NotFoundController();

            if ($project === null) {
                $notFoundController->run();
                return;
            }

            if ($project->getUserId() !== SessionManager::getLoggedInUserId()) {
                $notFoundController->run();
                return;
            }

            Logger::info("Deleting project " . $project->getId());
            Project::getDatabaseModel()->removeById($project->getId());

            Router::redirect('/projects');
        } else {
            DeleteProjectView::use();
        }
    }

}