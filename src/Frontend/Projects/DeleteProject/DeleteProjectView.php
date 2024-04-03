<?php

namespace A11yBuddy\Frontend\Projects\DeleteProject;

use A11yBuddy\Frontend\View;

class DeleteProjectView extends View
{
    public function render(array $data = []): void
    {
        ?>
        <h1>Delete project</h1>
        <p>Are you sure you want to delete this project?</p>
        <form method="post">
            <button type="submit" class="btn btn-danger">Yes, delete project</button>
        </form>
        <?php
    }
}