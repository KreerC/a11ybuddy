<?php

namespace A11yBuddy\Frontend;

/**
 * Views are responsible for rendering the user interface.
 * They should not contain any application logic.
 */
class View
{

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