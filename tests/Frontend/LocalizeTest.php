<?php

use PHPUnit\Framework\TestCase;
use A11yBuddy\Frontend\Localize;

class LocalizeTest extends TestCase
{
    public function testTranslate(): void
    {
        $localize = new Localize(
            "en",
            "welcome_message=Welcome to our website\ngreeting=Hello, :name:"
        );

        // Test translation with no variables
        $key = 'welcome_message';
        $expected = 'Welcome to our website';
        $actual = Localize::translate($key);
        $this->assertEquals($expected, $actual);

        // Test translation with variables
        $key = 'greeting';
        $variables = [':name:' => 'John'];
        $expected = 'Hello, John';
        $actual = Localize::translate($key, 'Hello, :name:', $variables);
        $this->assertEquals($expected, $actual);

        // Test with missing translation, but with default value
        $key = 'non_existent_key';
        $expected = 'Default value';
        $actual = Localize::translate($key, 'Default value');
        $this->assertEquals($expected, $actual);

        // Test with missing translation, but with default value and variables
        $key = 'non_existent_key';
        $variables = [':name:' => 'John'];
        $expected = 'Hello, John';
        $actual = Localize::translate($key, 'Hello, :name:', $variables);
        $this->assertEquals($expected, $actual);

        // Test translation with missing key
        $key = 'non_existent_key';
        $expected = 'Missing translation';
        $actual = Localize::translate($key);
        $this->assertEquals($expected, $actual);
    }
}