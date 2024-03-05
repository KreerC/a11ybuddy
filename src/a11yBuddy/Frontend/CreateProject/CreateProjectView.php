<?php

/*
   Copyright 2024 Casey Kreer

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

namespace A11yBuddy\Frontend\CreateProject;

use A11yBuddy\Frontend\View;

class CreateProjectView implements View
{

    public static function render(array $data = [])
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