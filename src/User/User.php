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
     * Gets a user object by their username.
     * 
     * @param string $username The username of the user to get.
     * @return User|null The user object, or null if the user does not exist.
     */
    public static function getByUsername(string $username): ?User
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


    private ?int $id;
    private string $displayName;
    private string $username;
    private string $email;
    private string $passwordHash;

    private int $status;

    /**
     * Creates a new user object.
     * 
     * @param array $dbRow The database row to create the user from. This should be an associative array with the following keys:
     * - display_name: The display name of the user.
     * - username: The username of the user.
     * - email: The email address of the user.
     * - password_hash: The password hash of the user.
     * - status: The status of the user.
     * - id: Optional - The ID of the user. This must only be used when the user is loaded from the database.
     */
    public function __construct(array $dbRow)
    {
        $this->displayName = $dbRow['display_name'] ?? '';
        $this->username = $dbRow['username'] ?? '';
        $this->email = $dbRow['email'] ?? '';
        $this->passwordHash = $dbRow['password_hash'] ?? '';

        $this->status = $dbRow['status'] ?? UserStatus::Unverified->value;

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
     * Sets the display name of the user. Does validation (length check)
     * 
     * @param string $displayName The new display name of the user.
     * @return bool True if the display name was set successfully, false if a user with the same display name already exists.
     */
    public function setDisplayName(string $displayName): bool
    {
        if (strlen($displayName) < 3 || strlen($displayName) > 50) {
            return false;
        }

        $this->displayName = $displayName;
        return true;
    }

    /**
     * @return string The username of the user.
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Sets the username of the user. Does validation (duplicate check, length check)
     * 
     * @param string $username The new username of the user.
     * @return bool True if the username was set successfully, false if a user with the same username already exists.
     */
    public function setUsername(string $username): bool
    {
        if (strlen($username) < 3 || strlen($username) > 20) {
            return false;
        }

        if (strlen($username) !== strspn($username, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_')) {
            return false;
        }

        if (User::getByUsername($username) !== null) {
            return false;
        }

        $this->username = $username;
        return true;
    }

    /**
     * @return string The email address of the user.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Sets the email address of the user. Does validation (duplicate check, format check)
     * When updating the value, make sure to re-verify the email address and to change the users' status to Unverified.
     * 
     * @param string $email The new email address of the user.
     * @return bool True if the email address was set successfully, false otherwise.
     */
    public function setEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (User::getByEmail($email) !== null) {
            return false;
        }

        $this->email = $email;
        return true;
    }

    /**
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
     * @param bool $validate Whether to run validation on the password.
     * @return bool True if the password has passed validation and has been set, false otherwise.
     */
    public function setPassword(string $password, bool $validate = true): bool
    {
        if ($validate) {
            if (strlen($password) < 8) {
                return false;
            }
        }

        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
        return true;
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