<?php

/*
   Copyright 2024 Casey Kreer

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

namespace A11yBuddy\User;

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

    }

    /**
     * Gets a user object by their ID.
     * 
     * @param int $id The ID of the user to get.
     * @return User|null The user object, or null if the user does not exist.
     */
    public static function getById(int $id): ?User
    {

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

}