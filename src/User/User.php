<?php

namespace A11yBuddy\User;

/**
 * A model of the user that can interact with the database.
 * Has all the properties and methods needed to interact with Users.
 */
class User
{

    /**
     * Gets a user object by their email address.
     * 
     * @param string $email The email address of the user to get.
     * @return User|null The user object, or null if the user does not exist.
     */
    public static function getByEmail(string $email): ?User
    {
        return null;
    }

    /**
     * Gets a user object by their ID.
     * 
     * @param int $id The ID of the user to get.
     * @return User|null The user object, or null if the user does not exist.
     */
    public static function getById(int $id): ?User
    {
        return null;
    }

    /**
     * Gets the currently logged in user object.
     * 
     * @return User|null The currently logged in user object, or null if no user is logged in.
     */
    public static function getLoggedInUser(): ?User
    {
        if (isset($_SESSION['user_id'])) {
            return self::getById($_SESSION['user_id']);
        } else {
            return null;
        }
    }


    private null|int $id;
    private string $displayName;
    private string $email;
    private string $passwordHash;

    private int $status;

    /**
     * Creates a new user object.
     * 
     * @param array $dbRow The database row to create the user from. This should be an associative array with the following keys:
     * - display_name: The display name of the user.
     * - email: The email address of the user.
     * - password_hash: The password hash of the user.
     * - status: The status of the user.
     * - id: Optional - The ID of the user. This must only be used when the user is loaded from the database.
     */
    public function __construct(array $dbRow)
    {
        $this->displayName = $dbRow['display_name'];
        $this->email = $dbRow['email'];
        $this->passwordHash = $dbRow['password_hash'];

        $this->status = $dbRow['status'];

        $this->id = $dbRow['id'] ?? null;
    }

    /**
     * Checks if the user is new (i.e. has not been saved to the database yet).
     * 
     * @return bool True if the user is new, false otherwise.
     */
    public function isNew(): bool
    {
        return $this->id === null;
    }

    /**
     * Saves the user to the database.
     * 
     * @return bool True if the user was saved successfully, false otherwise.
     */
    public function save(): bool
    {
        if ($this->isNew()) {
            // Insert the user into the database
        }

        // Update the user in the database

        //TODO: Implement this method
        return false;
    }

    /**
     * Returns the status of the user.
     * 
     * @return UserStatus The status of the user. Defaults to Unverified if the status is invalid.
     */
    public function getStatus(): UserStatus
    {
        $status = UserStatus::tryFrom($this->status);

        if ($status === null) {
            return UserStatus::Unverified;
        }

        return $status;
    }

    /** 
     * Sets the status of the user.
     * 
     * @param UserStatus $status The new status of the user.
     */
    public function setStatus(UserStatus $status)
    {
        $this->status = $status->value;
    }

    /**
     * Returns the display name of the user.
     * 
     * @return string The display name of the user.
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * Sets the display name of the user.
     * 
     * @param string $displayName The new display name of the user.
     */
    public function setDisplayName(string $displayName): void
    {
        $this->displayName = $displayName;
    }

    /**
     * Returns the email address of the user.
     * 
     * @return string The email address of the user.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Sets the email address of the user.
     * 
     * @param string $email The new email address of the user.
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Returns the password hash of the user.
     * 
     * @return string The password hash of the user.
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * Sets the password of the user. Will perform the hashing.
     * 
     * @param string $password The new password of the user. 
     */
    public function setPassword(string $password): void
    {
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Checks if the given password is correct.
     * 
     * @param string $password The password to check.
     * @return bool True if the password is correct, false otherwise.
     */
    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }


}