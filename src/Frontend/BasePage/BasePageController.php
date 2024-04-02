<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Application;
use A11yBuddy\Frontend\BasePageRenderer;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\Frontend\Localize;
use A11yBuddy\Router;

/**
 * Renders the basic structure of a page and handles routing for the main content
 */
class BasePageController extends Controller
{

    private BasePageRenderer $renderer;

    private Router $router;

    private mixed $subController;

    private array $routeData = [];

    public function __construct(BasePageRenderer $renderer)
    {
        $this->renderer = $renderer;

        $this->router = $this->getRenderer()->getRouter();
        $sub = $this->router->getControllerForRequest(Router::getRequestMethod(), Router::getRequestUri());
        $this->subController = $sub[0];
        $this->routeData = $sub[1];
    }

    /**
     * @return BasePageRenderer
     */
    public function getRenderer(): BasePageRenderer
    {
        return $this->renderer;
    }

    public function run(array $data = []): void
    {
        $isController = $this->subController instanceof Controller;

        // Check if this is allowed for the current user. Admins can do anything.
        if (!isset ($_SESSION["admin"]) && $isController) {
            $isLoggedIn = Application::getInstance()->getSessionManager()->isLoggedIn();

            // Is this controller for anonymous users but the user is logged in?
            if ($isLoggedIn && $this->subController->isForAnonymousOnly()) {
                $this->subController = new NotFoundController();
            }

            // Is this controller for authenticated users but the user is not logged in?
            else if (!$isLoggedIn && $this->subController->isForAuthenticatedOnly()) {
                $this->subController = new NotFoundController();
            }
        }

        // Is this controller for admin users but the user is not an admin?
        if (
            !isset ($_SESSION["admin"]) &&
            $isController &&
            $this->subController->isForAdminOnly()
        ) {
            $this->subController = new NotFoundController();
        }

        // Handle JSON
        if ($isController && $this->subController->getDisplayType() === "json") {
            header("Content-Type: application/json");
            $this->subController->run($this->routeData);
            return;
        }

        ?>

        <!DOCTYPE html>
        <html lang="<?= Localize::translate("locale", "en") ?>">

        <head>
            <?php
            HeadView::use([
                "title" => $isController ? $this->subController->getPageTitle() : "",
                "description" => $isController ? $this->subController->getPageDescription() : "",
                "nofollow" => $isController ? $this->subController->isNoFollow() : false,
            ]);
            ?>
        </head>

        <body>
            <?php
            NavigationView::use([]);
            ?>

            <main id="content">
                <div class="container mt-3">
                    <?php
                    if ($isController) {
                        $this->subController->run($this->routeData);
                    } else if (is_callable($this->subController)) {
                        $callable = $this->subController;
                        $callable($this->routeData);
                    }
                    ?>
                </div>
            </main>

            <footer class="mt-5">
                <?php
                FooterView::use([]);
                ?>
            </footer>
        </body>

        </html>

        <?php
    }

}