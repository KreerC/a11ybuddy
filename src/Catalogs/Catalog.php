<?php

namespace A11yBuddy\Catalogs;

class Catalog
{

    public static array $catalogs = [

        "en" => [
            "unassisted" => __DIR__ . "/en/unassisted.json",
        ],

        "de" => [
            "unassisted" => __DIR__ . "/de/unassisted.json",
        ],

    ];

    private array $catalog;

    private array $results = [];

    public function __construct(string $catalog, string $language = 'en')
    {
        if (in_array($catalog, array_keys(self::$catalogs[$language]))) {
            $this->catalog = json_decode(file_get_contents(self::$catalogs[$language][$catalog]), true);
        } else {
            throw new \Exception("Catalog not found");
        }
    }

    public function getName(): string
    {
        return $this->catalog['name'];
    }

    public function getAuthor(): string
    {
        return $this->catalog['created_by'];
    }

    public function getDescription(): string
    {
        return $this->catalog['description'];
    }

    public function getVersion(): string
    {
        return $this->catalog['version'];
    }

    public function getTestSteps(): array
    {
        return $this->catalog['steps'];
    }

    /**
     * Add a test result to the catalog
     * 
     * @param int $stepId The ID of the test step
     * @param mixed $result The result of the test
     * @param string|null $comment A comment to add to the test result
     */
    public function addTest(int $stepId, mixed $result, string $comment = null): void
    {
        $this->results[] = [
            'step' => $stepId,
            'result' => $result,
            'comment' => $comment,
        ];
    }

    /**
     * @return array The results of each test step that can be saved to the database
     */
    public function getResult(): array
    {
        $results = [];

        $results["test_name"] = $this->getName();
        $results["test_version"] = $this->getVersion();
        $results["test_description"] = $this->getDescription();
        $results["test_time"] = time();

        $results["results"] = [];

        foreach ($this->getTestSteps() as $id => $step) {
            $results[$id] = [
                'result' => $this->results[$id]['result'],
                'comment' => $this->results[$id]['comment'] ?? null,
            ];
        }

        return $results;
    }

}