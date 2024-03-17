<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Localize;
use A11yBuddy\Frontend\Controller;

class HomepageController extends Controller
{

    public function getPageTitle(): string
    {
        return Localize::translate("welcome", "Welcome to a11yBuddy");
    }

    //TODO - we need a much better homepage with some actual content

    public function run(array $data = []): void
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