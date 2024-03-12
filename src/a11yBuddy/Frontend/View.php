<?php

namespace A11yBuddy\Frontend;

/**
 * Views are responsible for rendering the user interface.
 * They should not contain any application logic.
 */
interface View
{

    /**
     * @param array $data An array of variables handed to the view by the controller
     */
    public static function render(array $data = []);

}