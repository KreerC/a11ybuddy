<?php

namespace A11yBuddy\Frontend;

use A11yBuddy\Application;
use A11yBuddy\Frontend\BasePage\NotFoundController;
use A11yBuddy\Router;

/**
 * Displays the content of a custom page supplied by the user, e.g. an Imprint or Privacy Policy page.
 */
class CustomPageController extends Controller
{

    private string $file = "";

    private string $renderMode = "markdown";

    private string $title = "";

    public function __construct()
    {
        $customPages = Application::getInstance()->getConfig()["custom_pages"] ?? [];

        $route = Router::getRequestUri();
        if (isset($customPages[$route])) {
            $this->renderMode = $customPages[$route]["type"];
            $lang = Localize::getInstance()->getLocale();

            // Check if a file for this language exists - otherwise use the default locale
            $this->file = $customPages[$route]["files"][$lang] ?? $customPages[$route]["files"]["en"] ?? "";

            $this->title = $customPages[$route]["title"][$lang] ?? $customPages[$route]["files"]["en"] ?? "";
        }
    }

    public function getPageTitle(): string
    {
        return $this->title;
    }

    public function run(array $data = []): void
    {
        if (!empty($this->file)) {
            $fileContent = file_get_contents($this->file);

            if ($this->renderMode === "markdown") {
                $markdownParser = new \Parsedown();
                $markdownParser->setSafeMode(true);

                echo $markdownParser->text($fileContent);
            } elseif ($this->renderMode === "html") {
                echo $fileContent;
            } else {
                throw new \Exception("Unknown custom page type: " . $this->renderMode);
            }
        } else {
            $this->notFound();
        }
    }

    /**
     * Displays a 404 error page if the custom page does not exist
     */
    private function notFound(): void
    {
        $notFoundController = new NotFoundController();
        $notFoundController->run();
    }

}