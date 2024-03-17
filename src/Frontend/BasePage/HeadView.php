<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Application;
use A11yBuddy\Frontend\View;

/**
 * Defines all meta information in the pages' <head> tag
 */
class HeadView extends View
{

    public function render(array $data = []): void
    {
        if (!empty($data["title"]))
            $title = $data['title'] . " - " . Application::getInstance()->getConfig()["app"]["name"];
        else
            $title = Application::getInstance()->getConfig()["app"]["name"];

        ?>
        <title>
            <?php echo $title; ?>
        </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="template/dependencies/bootstrap/css/bootstrap.min.css" />
        <?php
    }

}