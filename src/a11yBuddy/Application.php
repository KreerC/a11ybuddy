<?php

namespace A11yBuddy;

use A11yBuddy\Database\Database;
use A11yBuddy\Frontend\BasePageRenderer;
use A11yBuddy\User\SessionManager;

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


    private Database $database;

    private BasePageRenderer $basePageRenderer;

    private SessionManager $sessionManager;

    /**
     * @var array The configuration of the application. An example is in config.example.php.
     */
    private array $config;

    public function __construct(array $config = [])
    {
        self::$instance = $this;
        $this->config = $config;

        if (isset($config["db"])) {
            $this->database = new Database($config['db']);
        } else {
            // There are some default values, e.g. for testing.
            $this->database = new Database();
        }
        $this->sessionManager = new SessionManager();
        $this->basePageRenderer = new BasePageRenderer();
    }

    /**
     * @return Database
     */
    public function getDatabase(): Database
    {
        return $this->database;
    }

    /**
     * @return BasePageRenderer
     */
    public function getBasePageRenderer(): BasePageRenderer
    {
        return $this->basePageRenderer;
    }

    /**
     * @return SessionManager
     */
    public function getSessionManager(): SessionManager
    {
        return $this->sessionManager;
    }

    /**
     * @return array The configuration of the application.
     */
    public function getConfig(): array
    {
        return $this->config;
    }

}