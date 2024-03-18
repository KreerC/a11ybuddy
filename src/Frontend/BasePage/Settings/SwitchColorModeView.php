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
        <button onclick="toggleColorMode()">
            Toggle dark mode
        </button>
        <script>
            var selectedColorMode = localStorage.getItem('colorMode');

            if (selectedColorMode === null) {
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    localStorage.setItem('colorMode', 'dark');
                    selectedColorMode = 'dark';
                } else {
                    localStorage.setItem('colorMode', 'light');
                    selectedColorMode = 'light';
                }
            }

            document.documentElement.setAttribute('data-bs-theme', selectedColorMode);

            function toggleColorMode() {
                var newColorMode = selectedColorMode === 'light' ? 'dark' : 'light';
                selectedColorMode = newColorMode;
                localStorage.setItem('colorMode', newColorMode);
                document.documentElement.setAttribute('data-bs-theme', newColorMode);
            }
        </script>
        <?php
    }

}