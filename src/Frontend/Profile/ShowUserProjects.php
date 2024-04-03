<?php

namespace A11yBuddy\Frontend\Profile;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Projects\ListProjects\ProjectListView;

/**
 * Shows a list of projects for a user
 */
class ShowUserProjects
{

    /**
     * Renders a list of projects for a given user
     * 
     * @param int $userId The ID of the user to show projects for
     */
    public function query(int $userId): void
    {
        $db = Application::getInstance()->getDatabase();
        $query = $db->query("SELECT projects.*, users.username 
        FROM projects 
        JOIN users ON projects.user_id = users.id 
        WHERE user_id = :user_id
        ORDER BY updated_at DESC", [":user_id" => $userId]);
        $projects = $query->fetchAll(\PDO::FETCH_ASSOC);

        ProjectListView::use(["projects" => $projects]);
    }

}