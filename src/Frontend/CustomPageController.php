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

    public function getPageTitle(): string
    {
        //TODO implement custom page names for custom pages
        return "";
    }

    public function run(array $data = []): void
    {
        $customPages = Application::getInstance()->getConfig()["custom_pages"] ?? [];
        $route = Router::getRequestUri();
        if (isset($customPages[$route])) {
            $type = $customPages[$route]["type"];
            $lang = Localize::getInstance()->getLocale();

            // Check if a file for this language exists - otherwise use the default locale
            $file = $customPages[$route]["files"][$lang] ?? $customPages[$route]["files"]["en"];

            if (!file_exists($file)) {
                $this->notFound();
            }

            $fileContent = file_get_contents($file);

            if ($type === "markdown") {
                $markdownParser = new \Parsedown();
                $markdownParser->setSafeMode(true);

                echo $markdownParser->text($fileContent);
            } elseif ($type === "html") {
                echo $fileContent;
            } else {
                throw new \Exception("Unknown custom page type: " . $type);
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