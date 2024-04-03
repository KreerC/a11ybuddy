<?php

namespace A11yBuddy\Frontend\Projects\CreateProject;

use A11yBuddy\Frontend\BasePage\ErrorView;
use A11yBuddy\Frontend\View;

class CreateProjectView extends View
{

    public function render(array $data = []): void
    {
        // Show potential error messages first
        ErrorView::use($data);

        ?>
        <h1>Create a New Project</h1>
        <div class="row">
            <div class="col-lg-8">
                <form action="/projects/create" method="post">
                    <label class="form-label mb-3" for="project-name">Name</label>
                    <input class="form-control mb-3" type="text" id="project-name" name="project-name" required>

                    <label class="form-label mb-3" for="project-description">Description</label>
                    <textarea class="form-control mb-3" id="project-description" name="project-description" rows="3"
                        required></textarea>

                    <label class="form-label mb-3" for="project-url">URL</label>
                    <input class="form-control mb-3" type="url" id="project-url" name="project-url">

                    <label class="form-label mb-3" type="project-type">Type</label>
                    <select class="form-select mb-3" id="project-type" name="project-type">
                        <option value="0">Web</option>
                        <option value="1">Mobile Application</option>
                        <option value="2">Desktop Application</option>
                        <option value="3">Game</option>
                        <option value="4">Other</option>
                    </select>

                    <label class="form-label mb-3" for="project-status">Status</label>
                    <select class="form-select mb-3" id="project-status" name="project-status">
                        <option value="0">Public</option>
                        <option value="2">Private</option>
                    </select>

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