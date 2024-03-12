<?php

namespace A11yBuddy\Frontend;

use A11yBuddy\Application;
use A11yBuddy\Frontend\BasePage\BasePageController;
use A11yBuddy\Frontend\CreateProject\CreateProjectController;
use A11yBuddy\Frontend\CreateProject\CreateProjectView;
use A11yBuddy\Frontend\BasePage\HomepageView;
use A11yBuddy\Frontend\BasePage\NotFoundView;
use A11yBuddy\Router;

class BasePageRenderer
{

    private Router $router;
    private BasePageController $pageController;

    public function __construct()
    {
        $this->router = new Router();
        $this->registerRoutes();

        $this->pageController = new BasePageController($this);
    }

    public function render(): void
    {
        $this->pageController->run();
    }

    /**
     * Central location for registering routes for the application
     */
    private function registerRoutes()
    {
        // Add special routes
        $this->router->addRoute("GET", "/404", [NotFoundView::class, "render"]);

        // All other routes
        $this->router->addRoute("GET", "/", [HomepageView::class, "render"]);

        $this->router->addRoute("GET", "/create", [CreateProjectView::class, "render"]);
        $this->router->addRoute("POST", "/create", [CreateProjectController::class, "run"]);

        // Register custom pages
        $customPages = Application::getInstance()->getConfig()["custom_pages"] ?? [];
        foreach ($customPages as $route => $page) {
            /*
             * TODO: We allow the user to override previously defined routes if they want to supply their own custom landing page.
             * This might result in errors if the admin is not careful, so in the future this should be handled differently.
             */
            $this->router->addRoute("GET", $route, [CustomPageController::class, "run"], true);
        }
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

}