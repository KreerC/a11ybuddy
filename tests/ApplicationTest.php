<?php

use PHPUnit\Framework\TestCase;
use A11yBuddy\Application;

class ApplicationTest extends TestCase
{
    public function testInstanceIsSingleton(): void
    {
        $instance1 = Application::getInstance();
        $instance2 = Application::getInstance();

        $this->assertInstanceOf(Application::class, $instance1);
        $this->assertInstanceOf(Application::class, $instance2);
        $this->assertSame($instance1, $instance2);
    }
}