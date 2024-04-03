<?php

namespace A11yBuddy\Project;

/**
 * The type of a project
 */
enum ProjectType: int
{

    /**
     * A web project
     */
    case Web = 0;

    /**
     * A native mobile app
     */
    case Mobile = 1;

    /**
     * A desktop application
     */
    case Desktop = 2;

    /**
     * A game, regardless of platform
     */
    case Game = 3;

    /**
     * Any other type of project
     */
    case Other = 4;

}