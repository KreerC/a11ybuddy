<?php

namespace A11yBuddy;

use A11yBuddy\Database\Database;
use A11yBuddy\Frontend\BasePageRenderer;

/**
 * The starting point of the application.
 * Defines some basic configuration.
 * 
 * This class is a singleton. Use Application::getInstance() to get the current instance.
 */
class Application
{

    const VERSION = "0.0.1";
    const NAME = "a11yBuddy";

    private static ?Application $instance = null;

    private Database $database;

    private BasePageRenderer $basePageRenderer;

    /**
     * @var array The configuration of the application. An example is in config.example.php.
     */
    private array $config;

    public function __construct(array $config = [])
    {
        self::$instance = $this;
        $this->config = $config;

        $this->database = new Database($config['db']);
        $this->basePageRenderer = new BasePageRenderer();
    }

    /**
     * Singleton method to get the current instance of the Application.
     * 
     * @return Application The current instance of the Application.
     */
    public static function getInstance(): Application
    {
        if (self::$instance === null) {
            self::$instance = new Application();
        }
        return self::$instance;
    }

    /**
     * @return BasePageRenderer
     */
    public function getBasePageRenderer(): BasePageRenderer
    {
        return $this->basePageRenderer;
    }

    /**
     * @return Database
     */
    public function getDatabase(): Database
    {
        return $this->database;
    }

    /**
     * @return array The configuration of the application.
     */
    public function getConfig(): array
    {
        return $this->config;
    }

}