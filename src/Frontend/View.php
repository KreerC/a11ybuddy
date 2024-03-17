<?php

namespace A11yBuddy\Frontend;

/**
 * Views are responsible for rendering the user interface.
 * They should not contain any application logic.
 */
class View
{

    /**
     * If the view is simple, we can simplify the usage of it by using this static method.
     * 
     * @param array $data An array of variables handed to the view by the controller
     */
    public static function use(array $data = []): void
    {
        $view = new static();
        $view->render($data);
    }

    /**
     * Renders the view and outputs it to the user.
     * 
     * @param array $data An array of variables handed to the view by the controller
     */
    public function render(array $data = []): void
    {
        echo "";
    }

}