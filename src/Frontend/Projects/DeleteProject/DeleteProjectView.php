<?php

namespace A11yBuddy\Frontend\Projects\DeleteProject;

use A11yBuddy\Frontend\View;

class DeleteProjectView extends View
{
    public function render(array $data = []): void
    {
        /**
         * @var \A11yBuddy\Project\Project $project
         */
        $project = $data["project"];

        ?>
        <h1>Delete project
            <i>
                <?= $project->getName() ?>
            </i>
        </h1>
        <p>Are you sure you want to delete this project? This action cannot be undone.</p>

        <form method="post">
            <button type="submit" class="btn btn-danger">Yes, delete the project now</button>
        </form>

        <a href="/projects/<?= $project->getId() ?>" class="btn btn-secondary">No, go back</a>
        <?php
    }
}