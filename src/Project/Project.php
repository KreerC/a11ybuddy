<?php

namespace A11yBuddy\Project;

use A11yBuddy\Application;
use A11yBuddy\Database\DatabaseModel;
use A11yBuddy\Database\Model;
use A11yBuddy\Frontend\Localize;
use A11yBuddy\Logger;
use A11yBuddy\Utils\RandomString;

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
    private int $updatedAt;
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
        $this->updatedAt = isset($dbRow["updated_at"]) ? strtotime($dbRow['updated_at']) : time();
        $this->userId = $dbRow['user_id'] ?? 0;
        $this->language = $dbRow['language'] ?? Localize::getInstance()->getLocale();
        $this->status = ProjectStatus::tryFrom($dbRow['status'] ?? 0) ?? ProjectStatus::Public;
        $this->type = ProjectType::tryFrom($dbRow['type'] ?? 0) ?? ProjectType::Web;
    }

    public function saveToDatabase(): bool
    {
        $data = [
            "name" => $this->name,
            "text_identifier" => $this->getTextIdentifier() ?? RandomString::randomIdString(16),
            "description" => $this->description,
            "url" => $this->url,
            "created_at" => date('Y-m-d H:i:s', $this->createdAt),
            "updated_at" => date('Y-m-d H:i:s'),
            "user_id" => $this->userId,
            "language" => $this->language,
            "status" => $this->status->value,
            "type" => $this->type->value
        ];

        $this->textIdentifier = $data['text_identifier'];

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
        return htmlentities($this->name);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getTextIdentifier(): ?string
    {
        return $this->textIdentifier;
    }

    /**
     * Set the text identifier of the project. Must be unique and at least 3 characters long.
     * 
     * @param string $textIdentifier The new text identifier
     * 
     * @return bool True if the text identifier was set, false otherwise
     */
    public function setTextIdentifier(string $textIdentifier): bool
    {
        if (
            strlen($textIdentifier) > 2 &&
            self::getByTextIdentifier($textIdentifier) === null
        ) {
            $this->textIdentifier = $textIdentifier;
            return true;
        }

        return false;
    }

    /**
     * Generate a text identifier from the project name
     * 
     * @return string The generated text identifier
     */
    public function generateTextIdentifier(): string
    {
        $textIdentifier = strtolower(preg_replace('/[^a-z0-9]/', '', strtolower($this->getName())));
        return $textIdentifier;
    }

    public function getDescription(): string
    {
        return htmlentities($this->description);
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getUrl(): string
    {
        return htmlentities($this->url);
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
        return htmlentities($this->language);
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

    public function getUpdatedAt(): int
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(int $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}