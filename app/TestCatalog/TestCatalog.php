<?php

namespace App\TestCatalog;

class TestCatalog
{

    /**
     * @var string $name The name of the catalog
     */
    public string $name;

    /**
     * @var string $description The description of the catalog
     */
    public string $description;

    /**
     * @var array $testCases The test cases in the catalog. See BaseCatalog for an example.
     */
    public array $testCases;

    public static function getAllCatalogs(): array
    {
        return [
            "basic" => new BaseCatalog()
        ];
    }

    public static function getCatalog(string $catalog): BaseCatalog
    {
        $catalogs = self::getAllCatalogs();
        return $catalogs[$catalog];
    }

}