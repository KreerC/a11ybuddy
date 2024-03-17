<?php

namespace A11yBuddy\Frontend\CreateProject;

use A11yBuddy\Frontend\View;

class CreateProjectView extends View
{

    public function render(array $data = []): void
    {

        if (isset($data['error'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $data['error']; ?>
            </div>
            <?php
        }

        ?>
        <h1>Create a New Project</h1>
        <div class="row">
            <div class="col-lg-8">
                <form action="/create" method="post">
                    <label class="form-label mb-3" for="project-name">Project Name</label>
                    <input class="form-control mb-3" type="text" id="project-name" name="project-name" required>
                    <button class="btn btn-primary" type="submit">Create Project</button>
                </form>
            </div>
            <div class="col">
                Create a new project to start tracking accessibility issues.
            </div>
        </div>
        <?php
    }

}