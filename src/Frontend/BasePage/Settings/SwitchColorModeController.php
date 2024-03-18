<?php

namespace A11yBuddy\Frontend\BasePage\Settings;

use A11yBuddy\Frontend\Controller;

/**
 * Toggles the color mode of the page
 */
class SwitchColorModeController extends Controller
{

    public function run(array $data = []): void
    {
        if (!isset ($_SESSION["colorMode"])) {
            $_SESSION["colorMode"] = "dark";
        } else {
            unset($_SESSION["colorMode"]);
        }

        // If there is a referrer, redirect to it
        if (isset ($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            return;
        }

        // Otherwise, redirect to the home page
        header("Location: /");
    }

}