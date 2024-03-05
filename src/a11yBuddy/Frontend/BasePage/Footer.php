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

class Footer implements View
{

    public static function render(array $data = [])
    {
        ?>
        <footer>
            <div class="container">
                <p class="text-center">
                    <?php echo Application::NAME . " - " . Application::VERSION; ?>
                </p>
            </div>
            <script src="template/dependencies/jquery/jquery-3.5.1.min.js"></script>
            <script src="template/dependencies/bootstrap/js/bootstrap.min.js"></script>
        </footer>
        <?php
    }

}