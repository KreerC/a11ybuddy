<?php

namespace A11yBuddy\Frontend\BasePage\Settings;

use A11yBuddy\Frontend\View;

/**
 * Toggles the color mode of the page.
 */
class SwitchColorModeView extends View
{

    public function render(array $data = []): void
    {
        ?>
        <button onclick="toggleDarkMode()">
            Toggle dark mode
        </button>
        <script src="assets/js/darkModeToggle.js"></script>
        <?php
    }

}