<?php

namespace A11yBuddy\Project;

enum ProjectStatus: int
{
    case Public = 0;
    case Archived = 1;
    case Private = 2;
    case Draft = 3;

}