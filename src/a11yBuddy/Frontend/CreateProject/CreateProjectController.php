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

use A11yBuddy\Frontend\Controller;

class CreateProjectController implements Controller
{

    public function run(array $data = [])
    {
        // TODO

        // Return the view with an error message for the time being
        return CreateProjectView::render([
            'error' => 'This feature is not yet implemented'
        ]);
    }

}