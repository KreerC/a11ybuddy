<?php

namespace A11yBuddy\Frontend\Projects\ListProjects;

use A11yBuddy\Frontend\View;

/**
 * Shows a list of projects for the logged in user
 */
class UserProjectView extends View
{

    public function render(array $data = []): void
    {
        ?>
        <h1>Your projects</h1>

        <div class="row row-cols-1">
            <div class="col-3">
                <a href="/create" class="btn btn-primary">
                    Create a new project
                </a>
            </div>
            <div class="col-lg-9">
                <?php
                ProjectListView::use($data);
                ?>
            </div>
        </div>
        <?php
    }
}