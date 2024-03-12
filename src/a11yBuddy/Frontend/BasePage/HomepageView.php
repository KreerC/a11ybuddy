<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Localize;
use A11yBuddy\Frontend\View;

class HomepageView implements View
{

    //TODO - we need a much better homepage with some actual content

    public static function render(array $data = [])
    {
        ?>
        <h1>
            <?php echo Localize::translate("welcome", "Welcome to a11yBuddy") ?>
        </h1>
        <p>
            <?php echo Application::getInstance()->getSessionManager()->isLoggedIn() ? "You are logged in." : "You are not logged in." ?>
        </p>
        <p>
            <?php echo "Your session ID is " . session_id() ?>
        </p>
        <?php
    }

}