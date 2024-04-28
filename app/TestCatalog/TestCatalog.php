<?php

namespace App\TestCatalog;

class TestCatalog
{

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