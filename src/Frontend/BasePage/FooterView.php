<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Application;
use A11yBuddy\Frontend\BasePage\Settings\SwitchColorModeView;
use A11yBuddy\Frontend\Localize;
use A11yBuddy\Frontend\View;

/**
 * Outputs the content of the <footer> tag
 */
class FooterView extends View
{

    public function render(array $data = []): void
    {
        ?>
        <hr class="mb-3" aria-hidden="true">
        <div class="container">
            <p class="text-center">
                <?= Application::NAME . " - " . Application::VERSION; ?>
            </p>
            <p class="text-center">
                <?php
                // Output custom footer links
                $links = Application::getInstance()->getConfig()["footer"]["links"];
                $locale = Localize::getInstance()->getLocale();

                if (isset ($links[$locale])) {
                    foreach ($links[$locale] as $link => $title) {
                        echo '<a href="' . $link . '">' . $title . '</a> ';
                    }
                }
                ?>
            </p>
            <p class="text-center">
                <?php SwitchColorModeView::use(); ?>
            </p>
        </div>

        <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <?php
    }

}