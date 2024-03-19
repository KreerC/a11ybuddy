<?php

namespace A11yBuddy\Frontend;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Authentication\LoginController;
use A11yBuddy\Frontend\Authentication\LogoutController;
use A11yBuddy\Frontend\BasePage\BasePageController;
use A11yBuddy\Frontend\BasePage\HomepageController;
use A11yBuddy\Frontend\Projects\CreateProject\CreateProjectController;
use A11yBuddy\Frontend\Projects\ProjectDetails\ShowProjectDetailsController;
use A11yBuddy\Frontend\Projects\ListProjects\ShowUserProjectsController;
use A11yBuddy\Router;

/**
 * Handles the registration of routes and initiates the rendering of the page
 */
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
    private function registerRoutes(): void
    {
        // All routes
        $this->router->addRoute("GET", "/", HomepageController::class);

        // Authentication
        $this->router->addRoute("GET", "/login", LoginController::class);
        $this->router->addRoute("POST", "/login", LoginController::class);
        $this->router->addRoute("GET", "/logout", LogoutController::class);

        // Projects
        $this->router->addRoute("GET", "/create", CreateProjectController::class);
        $this->router->addRoute("POST", "/create", CreateProjectController::class);

        $this->router->addRoute("GET", "/projects", ShowUserProjectsController::class);
        $this->router->addRoute("GET", "/projects/{id}", ShowProjectDetailsController::class);

        // Register custom pages
        $customPages = Application::getInstance()->getConfig()["custom_pages"] ?? [];
        foreach ($customPages as $route => $page) {
            /*
             * TODO: We allow the user to override previously defined routes if they want to supply their own custom landing page.
             * This might result in errors if the admin is not careful, so in the future this should be handled differently.
             */
            $this->router->addRoute("GET", $route, CustomPageController::class, true);
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