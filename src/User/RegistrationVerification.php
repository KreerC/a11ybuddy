<?php

namespace A11yBuddy\User;

use A11yBuddy\Database\DatabaseModel;
use A11yBuddy\Database\Model;
use A11yBuddy\Utils\RandomString;

class RegistrationVerification extends Model
{

    public static function getDatabaseModel(): DatabaseModel
    {
        return new DatabaseModel('registration_verification');
    }

    public static function createInstanceFromDatabase(array $data): RegistrationVerification
    {
        return new RegistrationVerification($data);
    }

    /**
     * Get a registration verification by its token
     * 
     * @param string $token The token of the registration verification
     * 
     * @return RegistrationVerification|null The registration verification object, or null if no registration verification was found.
     */
    public static function getByToken(string $token): ?RegistrationVerification
    {
        $verification = self::getDatabaseModel()->getByKey("token", $token);

        if (empty($verification)) {
            return null;
        }

        return self::createInstanceFromDatabase($verification[0]);
    }

    private ?int $id = null;
    private string $token;
    private int $userId;
    private int $createdAt;
    private int $try;

    public function __construct(array $dbRow = [])
    {
        $this->id = $dbRow['id'] ?? null;
        $this->token = $dbRow['token'] ?? RandomString::randomIdString(32);
        $this->userId = $dbRow['user_id'] ?? 1;
        $this->createdAt = strtotime($dbRow['created_at']) ?? time();
        $this->try = $dbRow['try'] ?? 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function saveToDatabase(): bool
    {
        $data = [
            "token" => $this->token,
            "user_id" => $this->userId,
            "created_at" => date('Y-m-d H:i:s', $this->createdAt),
            "try" => $this->try
        ];

        $result = self::getDatabaseModel()->add($data);

        if ($result) {
            $this->id = $result;
        }

        return $result;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int The unix timestamp of the creation date of the registration verification.
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt The unix timestamp of the creation date of the registration verification. Can be set automatically by the constructor.
     */
    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getTry(): int
    {
        return $this->try;
    }

    public function setTry(int $try): void
    {
        $this->try = $try;
    }

}