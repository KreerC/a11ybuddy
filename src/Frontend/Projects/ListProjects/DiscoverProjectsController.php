<?php

namespace A11yBuddy\Frontend\Projects\ListProjects;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Controller;

/**
 * Shows a list of projects for the logged in user
 */
class DiscoverProjectsController extends Controller
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
        $query = $db->query("SELECT projects.*, users.username
        FROM projects
        JOIN users ON projects.user_id = users.id
        ORDER BY projects.updated_at DESC
        LIMIT 10;");
        $projects = $query->fetchAll(\PDO::FETCH_ASSOC);

        ?>
        <h1>Discover projects</h1>
        <p>Here are some of the latest projects on A11yBuddy:</p>
        <?php
        ProjectListView::use(["projects" => $projects]);
    }

}