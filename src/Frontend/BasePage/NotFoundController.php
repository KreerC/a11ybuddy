<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Frontend\Localize;
use A11yBuddy\Frontend\Controller;

/**
 * A controller that is invoked when something does not exist.
 * Sends a 404 response code automatically.
 */
class NotFoundController extends Controller
{

    public static function use(): void
    {
        $controller = new self();
        $controller->run();
    }

    public function isNoFollow(): bool
    {
        return true;
    }

    public function getPageTitle(): string
    {
        return Localize::translate("not_found", "Page Not Found");
    }

    public function run(array $data = []): void
    {
        http_response_code(404);
        ?>
        <h1>
            <?php echo Localize::translate("not_found", "Page Not Found"); ?>
        </h1>
        <p>
            <?php echo Localize::translate("not_found_explain", "The page you are looking for does not exist"); ?>
        </p>
        <a href="/">
            <?php echo Localize::translate("return_home", "Return to the home page"); ?>
        </a>
        <?php
    }

}