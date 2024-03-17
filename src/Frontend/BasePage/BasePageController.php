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

        // Handle JSON
        if ($this->subController instanceof Controller && $this->subController->getDisplayType() === "json") {
            header("Content-Type: application/json");
            $this->subController->run($this->routeData);
            return;
        }

        ?>

        <!DOCTYPE html>
        <html lang="<?php echo Localize::translate("locale", "en") ?>">

        <head>
            <?php
            $head = new HeadView();
            $head->render(["title" => $this->subController instanceof Controller ? $this->subController->getPageTitle() : ""]);
            ?>
        </head>

        <body>
            <?php
            $nav = new NavigationView();
            $nav->render([]);
            ?>

            <main>
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
                <?php $footer = new FooterView();
                $footer->render([]); ?>
            </footer>
        </body>

        </html>

        <?php
    }

}