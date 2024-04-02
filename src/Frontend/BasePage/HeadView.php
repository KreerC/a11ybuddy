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
        if (!empty ($data["title"]))
            $title = $data['title'] . " - " . Application::getInstance()->getConfig()["app"]["name"];
        else
            $title = Application::getInstance()->getConfig()["app"]["name"];

        ?>
        <title>
            <?= $title; ?>
        </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php
        if (!empty ($data["description"])) {
            ?>
            <meta name="description" content="<?= $data["description"] ?>">
            <?php
        }

        if (!empty ($data["nofollow"])) {
            ?>
            <meta name="robots" content="nofollow,noindex">
            <?php
        }
        ?>

        <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css" />
        <?php
    }

}