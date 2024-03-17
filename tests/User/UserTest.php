<?php

use PHPUnit\Framework\TestCase;
use A11yBuddy\User\User;

class UserTest extends TestCase
{
    public function testSetPassword(): void
    {
        $user = new User([
            "display_name" => "John Doe",
            "username" => "john_doe",
            "email" => "john@doe.invalid",
            "password_hash" => "",
            "status" => 0
        ]);

        // Test setting a valid password
        $result = $user->setPassword('password');
        $this->assertTrue($result);

        $result = $user->setPassword('123456');
        $this->assertFalse($result);

        // Test whether the password the password has not been updated and the first one is still correct
        $this->assertTrue($user->checkPassword('password'));

        // Test whether an incorrect password is not accepted
        $this->assertFalse($user->checkPassword('incorrect-password'));
    }

    public function testSetEmail(): void
    {
        $user = new User([
            "display_name" => "John Doe",
            "username" => "john_doe",
            "email" => "john@doe.invalid",
            "password_hash" => "",
            "status" => 0
        ]);

        // Test setting a valid email
        $this->assertTrue($user->setEmail('john2@doe.invalid'));
        $this->assertEquals('john2@doe.invalid', $user->getEmail());

        // Test setting an invalid email
        $this->assertFalse($user->setEmail('invalid-email'));
        $this->assertNotEquals('invalid-email', $user->getEmail());
        $this->assertEquals('john2@doe.invalid', $user->getEmail());

        // TODO test whether duplicate checking works
    }

    public function testSetUsername(): void
    {
        $user = new User([
            "display_name" => "John Doe",
            "username" => "john_doe",
            "email" => "john@doe.invalid",
            "password_hash" => "",
            "status" => 0
        ]);

        // Test setting a valid username
        $this->assertTrue($user->setUsername('john_doe2'));
        $this->assertEquals('john_doe2', $user->getUsername());

        // Test setting an invalid username
        $this->assertFalse($user->setUsername('invalid-username'));
        $this->assertNotEquals('invalid-username', $user->getUsername());
        $this->assertEquals('john_doe2', $user->getUsername());

        // TODO test whether duplicate checking works
    }
}