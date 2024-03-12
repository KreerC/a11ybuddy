<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Application;
use A11yBuddy\Frontend\View;

/**
 * Defines all meta information in the pages' <head> tag
 */
class HeadView implements View
{

    public static function render(array $data = [])
    {
        ?>
        <title>
            <?php echo Application::NAME; // TODO needs to change dynamically to what the current page is    ?>
        </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="template/dependencies/bootstrap/css/bootstrap.min.css" />
        <?php
    }

}