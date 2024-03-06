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
use A11yBuddy\Frontend\Localize;
use A11yBuddy\Frontend\View;
use A11yBuddy\Router;

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

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link<?php echo Router::getRequestUri() === "/discover" ? ' active " aria-current="page' : '' ?>"
                                href="/discover">
                                <?php echo Localize::translate("discover", "Discover") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?php echo Router::getRequestUri() === "/create" ? ' active " aria-current="page' : '' ?>"
                                href="/create">
                                <?php echo Localize::translate("create", "Create new project") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?php echo Router::getRequestUri() === "/my-projects" ? ' active " aria-current="page' : '' ?>"
                                href="/my-projects">
                                <?php echo Localize::translate("my_projects", "My projects") ?>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <?php echo Localize::translate("account", "Account") ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/login">
                                        <?php echo Localize::translate("login", "Log In") ?>
                                    </a></li>
                                <li><a class="dropdown-item" href="/signup">
                                        <?php echo Localize::translate("signup", "Sign Up") ?>
                                    </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
    }

}