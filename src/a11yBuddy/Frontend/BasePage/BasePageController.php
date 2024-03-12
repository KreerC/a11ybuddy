<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Frontend\BasePageRenderer;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\Frontend\Localize;
use A11yBuddy\Router;

/**
 * Renders the basic structure of a page and handles routing for the main content
 */
class BasePageController implements Controller
{

    private BasePageRenderer $renderer;

    public function __construct(BasePageRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @return BasePageRenderer
     */
    public function getRenderer(): BasePageRenderer
    {
        return $this->renderer;
    }

    public function run(array $data = [])
    {
        ?>

        <!DOCTYPE html>
        <html lang="<?php echo Localize::translate("locale", "en") ?>">

        <head>
            <?php HeadView::render($data); ?>
        </head>

        <body>
            <?php NavigationView::render($data); ?>

            <main>
                <div class="container mt-3">
                    <?php
                    $router = $this->getRenderer()->getRouter();
                    $router->handleRequest(Router::getRequestMethod(), Router::getRequestUri());
                    ?>
                </div>
            </main>

            <footer class="mt-5">
                <?php FooterView::render($data); ?>
            </footer>
        </body>

        </html>

        <?php
    }

}