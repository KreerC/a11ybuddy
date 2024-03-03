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

namespace A11yBuddy;

/**
 * The starting point of the application.
 * Defines some basic configuration and starts the application.
 */
class Application {

    const VERSION = "0.0.1";
    const NAME = "a11yBuddy";

    public function __construct() {
        echo self::NAME . " v" . self::VERSION . " is up and running.";
    }

}