<?php

namespace A11yBuddy\Project;

use A11yBuddy\Application;
use A11yBuddy\Database\DatabaseModel;
use A11yBuddy\Database\Model;
use A11yBuddy\Frontend\Localize;
use A11yBuddy\Logger;

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
    private ?string $textIdentifier;
    private string $description;
    private string $url;
    private int $createdAt;
    private int $userId;
    private string $language;
    private ProjectStatus $status;
    private ProjectType $type;

    public function __construct(array $dbRow = [])
    {
        $this->id = $dbRow['id'] ?? null;
        $this->name = $dbRow['name'] ?? '';
        $this->textIdentifier = $dbRow['text_identifier'] ?? null;
        $this->description = $dbRow['description'] ?? '';
        $this->url = $dbRow['url'] ?? '';
        $this->createdAt = isset($dbRow["created_at"]) ? strtotime($dbRow['created_at']) : time();
        $this->userId = $dbRow['user_id'] ?? 0;
        $this->language = $dbRow['language'] ?? Localize::getInstance()->getLocale();
        $this->status = ProjectStatus::tryFrom($dbRow['status']) ?? ProjectStatus::Public;
        $this->type = ProjectType::tryFrom($dbRow['type']) ?? ProjectType::Web;
    }

    public function saveToDatabase(): bool
    {
        $data = [
            "name" => $this->name,
            "text_identifier" => $this->textIdentifier ?? $this->generateTextIdentifier(),
            "description" => $this->description,
            "url" => $this->url,
            "created_at" => date('Y-m-d H:i:s', $this->createdAt),
            "user_id" => $this->userId,
            "language" => $this->language,
            "status" => $this->status->value,
            "type" => $this->type->value
        ];

        if ($this->id === null) {
            $result = self::getDatabaseModel()->add($data);
            if ($result !== false) {
                $this->id = $result;
                return true;
            }

            Logger::error('Could not save project ' . $this->getName() . ' to the database');
        } else {
            $result = self::getDatabaseModel()->updateById($this->id, $data);
        }

        return $result;
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getTextIdentifier(): string
    {
        return $this->textIdentifier;
    }

    public function setTextIdentifier(string $textIdentifier): void
    {
        $this->textIdentifier = $textIdentifier;
    }

    /**
     * Generate a text identifier from the project name
     * 
     * @return string The generated text identifier
     */
    public function generateTextIdentifier(): string
    {
        return strtolower(trim($this->name, "- \n\r\t\v\x00"));
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getStatus(): ProjectStatus
    {
        return $this->status;
    }

    public function setStatus(ProjectStatus|int $status): void
    {
        if ($status instanceof ProjectStatus) {
            $status = $status->value;
        } else {
            $status = ProjectStatus::tryFrom($status) ?? ProjectStatus::Public;
        }
    }

    public function getType(): ProjectType
    {
        return $this->type;
    }

    public function setType(ProjectType|int $type): void
    {
        if ($type instanceof ProjectType) {
            $type = $type->value;
        } else {
            $type = ProjectType::tryFrom($type) ?? ProjectType::Web;
        }
    }

}