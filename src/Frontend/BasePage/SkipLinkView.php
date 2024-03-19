<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Frontend\View;

/**
 * Provides a skip link to the main content
 */
class SkipLinkView extends View
{
    public function render(array $data = []): void
    {
        ?>
        <a href="#content" class="visually-hidden-focusable">
            Skip to main content
        </a>
        <?php
    }

}