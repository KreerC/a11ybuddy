<?php

namespace A11yBuddy\Project;

class Project
{

    private string $name;

    public function __construct(array $dbRow = [])
    {
        $this->name = $dbRow['name'] ?? '';

    }

    public function getName(): string
    {
        return $this->name;
    }

}