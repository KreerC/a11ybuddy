<?php

namespace A11yBuddy\Frontend;

/**
 * Controllers are responsible for handling user input and deciding what to do with it.
 * They are the glue between the user interface and the application logic.
 */
class Controller
{

    /**
     * Default function for a controller that runs when it is invoked.
     * This should call do the necessary work to handle the user's request,
     * like invoking a view.
     * 
     * @param array $data An array of variables parsed from the URI
     */
    public function run(array $data = []): void
    {
        return;
    }

    /**
     * Get the title of the page that the controller will return.
     * This will be used in the <title> tag of the HTML page.
     */
    public function getPageTitle(): string
    {
        return "";
    }

    /**
     * Get the description of the page that the controller will return.
     * This will be used in the <meta name="description"> tag of the HTML page.
     */
    public function getPageDescription(): string
    {
        return "";
    }

    /**
     * Get the type of display that the controller will return.
     * Can be "html" or "json".
     */
    public function getDisplayType(): string
    {
        return "html";
    }

}