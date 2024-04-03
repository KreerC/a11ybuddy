<?php

namespace A11yBuddy\Frontend\Projects\ListProjects;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Controller;

/**
 * Shows a list of projects for the logged in user
 */
class DiscoverProjectsController extends Controller
{

    public function getPageTitle(): string
    {
        return 'Discover projects';
    }

    public function run(array $data = []): void
    {
        $db = Application::getInstance()->getDatabase();

        if (!isset($_GET['q']) || empty($_GET['q'])) {
            $query = $db->query("SELECT projects.*, users.username
        FROM projects
        JOIN users ON projects.user_id = users.id      
        WHERE projects.status = 0
        ORDER BY projects.updated_at DESC
        LIMIT 10;");
        } else {
            $query = $db->query("SELECT projects.*, users.username
        FROM projects
        JOIN users ON projects.user_id = users.id
        WHERE (projects.name LIKE :q OR users.username LIKE :q OR projects.description LIKE :q) AND projects.status = 0
        ORDER BY projects.updated_at DESC
        LIMIT 10;", [":q" => "%" . $_GET['q'] . "%"]);
        }

        $projects = $query->fetchAll(\PDO::FETCH_ASSOC);

        ?>
        <h1>Discover projects</h1>

        <form action="/discover" class="mb-5" method="get">
            <div class="row">
                <div class="col-auto">
                    <input class="form-control" type="text" name="q" id="search" placeholder="Search projects"
                        value="<?= htmlentities($_GET["q"] ?? "") ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        <?php
        ProjectListView::use(["projects" => $projects]);
    }

}