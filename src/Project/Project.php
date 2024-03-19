<?php

namespace A11yBuddy\Project;

use A11yBuddy\Application;

class Project
{

    /**
     * @param string $textIdentifier The text identifier of the project to get.
     * @return Project|null The project object, or null if the project does not exist.
     */
    public static function getByTextIdentifier(string $textIdentifier): ?Project
    {
        $db = Application::getInstance()->getDatabase();
        $result = $db->query('SELECT * FROM projects WHERE text_identifier = :text_identifier', [':text_identifier' => $textIdentifier]);

        $result = $result->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return new Project($result);
    }

    private ?int $id = null;
    private string $name;

    public function __construct(array $dbRow = [])
    {
        $this->id = $dbRow['id'] ?? null;
        $this->name = $dbRow['name'] ?? '';
    }

    public function getWorkflows(): array
    {
        if ($this->id === null) {
            return [];
        }

        $db = Application::getInstance()->getDatabase();
        $result = $db->query('SELECT * FROM workflows WHERE project = :project', [':project' => $this->id]);
        $result = $result->fetchAll(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return [];
        }

        return $result; //TODO map to Workflow objects
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

}