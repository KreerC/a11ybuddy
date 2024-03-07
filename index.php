<?php

require_once("vendor/autoload.php");

use A11yBuddy\Application;

$config = require_once("config.php");

if ($config === null) {
    throw new Exception("Configuration file not found.");
}

$app = new Application($config);
$app->getBasePageRenderer()->render();
