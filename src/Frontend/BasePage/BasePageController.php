<?php

namespace A11yBuddy\Frontend\BasePage;

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

        // Check if this is allowed for the current user. Admins can do anything.
        if (!isset ($_SESSION["admin"])) {
            // Is this controller for anonymous users but the user is logged in?
            if (
                isset ($_SESSION["user_id"]) &&
                $this->subController instanceof Controller &&
                $this->subController->isForAnonymousOnly()
            ) {
                $this->subController = new NotFoundController();
            }
            // Is this controller for authenticated users but the user is not logged in?
            else if (
                !isset ($_SESSION["user_id"]) &&
                $this->subController instanceof Controller &&
                $this->subController->isForAuthenticatedOnly()
            ) {
                $this->subController = new NotFoundController();
            }
        }

        // Is this controller for admin users but the user is not an admin?
        if (
            isset ($_SESSION["admin"]) &&
            $this->subController instanceof Controller &&
            $this->subController->isForAdminOnly()
        ) {
            $this->subController->setRenderer($this->renderer);
        }

        // Handle JSON
        if ($this->subController instanceof Controller && $this->subController->getDisplayType() === "json") {
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
                "title" => $this->subController instanceof Controller ? $this->subController->getPageTitle() : "",
                "description" => $this->subController instanceof Controller ? $this->subController->getPageDescription() : "",
                "nofollow" => $this->subController instanceof Controller ? $this->subController->isNoFollow() : false,
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
                    if ($this->subController instanceof Controller) {
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