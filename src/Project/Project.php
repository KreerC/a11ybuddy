<?php

namespace A11yBuddy\Project;

use A11yBuddy\Application;
use A11yBuddy\Database\DatabaseModel;
use A11yBuddy\Database\Model;

class Project extends Model
{

    public static function getDatabaseModel(): DatabaseModel
    {
        return new DatabaseModel('projects');
    }

    public static function createInstanceFromDatabase(array $data): Project
    {
        return new Project($data);
    }

    /**
     * Get a project by its text identifier
     * 
     * @param string $textIdentifier The text identifier of the project
     * 
     * @return Project|null The project object, or null if no project was found.
     */
    public static function getByTextIdentifier(string $textIdentifier): ?Project
    {
        $project = self::getDatabaseModel()->getByKey("text_identifier", $textIdentifier);

        if (empty($project)) {
            return null;
        }

        return self::createInstanceFromDatabase($project[0]);
    }

    private ?int $id = null;
    private string $name;

    public function __construct(array $dbRow = [])
    {
        $this->id = $dbRow['id'] ?? null;
        $this->name = $dbRow['name'] ?? '';
    }

    public function saveToDatabase(): bool
    {
        return false; //TODO implement
    }

    public function getWorkflows(): array
    {
        if ($this->id === null) {
            return [];
        }

        $db = Application::getInstance()->getDatabase();
        $result = $db->query('SELECT * FROM workflows WHERE project = :project', [':project' => $this->id]);
        $result = $result->fetchAll(\PDO::FETCH_ASSOC);

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