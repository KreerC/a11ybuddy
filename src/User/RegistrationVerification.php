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

    public function __construct(array $dbRow = [])
    {
        $this->id = $dbRow['id'] ?? null;
        $this->token = $dbRow['token'] ?? RandomString::randomIdString(32);
        $this->userId = $dbRow['user_id'] ?? 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function saveToDatabase(): bool
    {
        $data = [
            "token" => $this->token,
            "user_id" => $this->userId
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

}