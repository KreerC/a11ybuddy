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

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Application;
use A11yBuddy\Frontend\View;

class NavigationView implements View
{

    public static function render(array $data = [])
    {
        ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <?php echo Application::NAME; ?>
                </a>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/discover">Discover</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/create">Create new project</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/my-projects">My projects</a>
                        </li>
                    </ul>
                </div>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"></button>
            </div>
        </nav>
        <?php
    }

}