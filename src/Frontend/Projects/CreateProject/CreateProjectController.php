<?php

namespace A11yBuddy\Frontend\Projects\CreateProject;

use A11yBuddy\Frontend\Controller;
use A11yBuddy\Project\Project;
use A11yBuddy\Project\ProjectStatus;
use A11yBuddy\Project\ProjectType;
use A11yBuddy\Router;
use A11yBuddy\User\SessionManager;

class CreateProjectController extends Controller
{

    public function isForAuthenticatedOnly(): bool
    {
        return true;
    }

    public function getPageTitle(): string
    {
        return 'Create a new project';
    }

    public function run(array $data = []): void
    {
        $errors = [];

        if (
            isset($_POST["project-name"]) &&
            isset($_POST["project-description"])
        ) {
            $project = new Project();
            $project->setName($_POST["project-name"]);
            $project->setDescription($_POST["project-description"]);
            $project->setTextIdentifier($project->generateTextIdentifier());
            $project->setUserId(SessionManager::getLoggedInUserId());

            if (isset($_POST["project-type"])) {
                if (in_array($_POST["project-type"], ProjectType::cases())) {
                    $project->setType($_POST["project-type"]);
                }
            }

            if (isset($_POST["project-status"])) {
                if (in_array($_POST["project-status"], ProjectStatus::cases())) {
                    $project->setStatus($_POST["project-status"]);
                }
            }

            if (isset($_POST["project-url"])) {
                if (filter_var($_POST["project-url"], FILTER_VALIDATE_URL)) {
                    $project->setUrl($_POST["project-url"]);
                }
            }

            $project->saveToDatabase();

            Router::redirect("/projects/" . $project->getTextIdentifier());
        } else {
            CreateProjectView::use($errors);
        }
    }

}