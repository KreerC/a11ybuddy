<?php

namespace A11yBuddy\Database;

abstract class Model
{

    /**
     * @return DatabaseModel The database model for the model
     */
    public abstract static function getDatabaseModel(): DatabaseModel;

    /**
     * Create an instance of the model from the database output, which is fetched as an associative array
     * 
     * @param array $data The data from the database
     * 
     * @return Model|null The instance of the model or null if the instance could not be created
     */
    public abstract static function createInstanceFromDatabase(array $data): ?Model;

    /**
     * Get an instance of the model by its ID
     * 
     * @param int $id The ID of the instance
     * 
     * @return Model|null The instance of the model, or null if no instance with the ID was found
     */
    public static function getById(int $id): ?Model
    {
        $data = static::getDatabaseModel()->getById($id);

        if (empty($data)) {
            return null;
        }

        return static::createInstanceFromDatabase($data[0]);
    }

    /**
     * Get the ID of the instance.
     * 
     * @return null|int The integer ID of the instance in the database. Will be null if the instance has not been saved to the database yet.
     */
    public abstract function getId(): ?int;

    /**
     * Save the instance data to the database
     * 
     * @return bool Whether the data was saved successfully
     */
    public abstract function saveToDatabase(): bool;

}