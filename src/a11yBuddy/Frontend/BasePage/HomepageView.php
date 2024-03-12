<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Frontend\Localize;
use A11yBuddy\Frontend\View;

class HomepageView implements View
{

    public static function render(array $data = [])
    {
        ?>
        <h1>
            <?php echo Localize::translate("welcome", "Welcome to a11yBuddy") ?>
        </h1>
        <?php
    }

}