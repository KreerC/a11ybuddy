<?php

// Warning: This file is only here for demonstration and development purposes.
// When you are hosting this application publicly, please consider writing a better index.php file
// that includes proper error handling and security measures.

session_start();
require_once ("vendor/autoload.php");

use A11yBuddy\Application;

$config = require_once ("config.php");

// Check if there is an example config file
if (file_exists("config.example.php")) {
    $exampleConfig = require_once ("config.example.php");

    // Tell the user which keys are missing in their config file
    $missingKeys = array_diff_key($exampleConfig, $config);
    if (!empty ($missingKeys)) {
        echo "Your config file is missing the following keys:\n";
        foreach ($missingKeys as $key => $value) {
            echo "  - $key\n";
        }
        echo "Please add them to your config file.\n";
        exit (1);
    }
}

$app = new Application($config);

// If we are a CLI script, only run the periodic tasks
if (php_sapi_name() === 'cli') {
    $taskManager = new A11yBuddy\Cronjob\CronjobTaskManager();
    $taskManager->runTasks();
    exit (0);
}

$app->getBasePageRenderer()->render();
