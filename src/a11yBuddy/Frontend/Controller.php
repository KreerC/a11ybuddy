<?php

namespace A11yBuddy\Frontend;

/**
 * Controllers are responsible for handling user input and deciding what to do with it.
 * They are the glue between the user interface and the application logic.
 */
interface Controller
{

    /**
     * Default function for a controller that runs when it is invoked.
     * 
     * @param array $data An array of variables parsed from the URI
     */
    public function run(array $data = []);

}