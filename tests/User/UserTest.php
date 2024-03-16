<?php

use PHPUnit\Framework\TestCase;
use A11yBuddy\User\User;

class UserTest extends TestCase
{
    public function testSetPassword(): void
    {
        $user = new User([
            "display_name" => "John Doe",
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
            "email" => "john@doe.invalid",
            "password_hash" => "",
            "status" => 0
        ]);

        // Test setting a valid email
        $this->assertTrue($user->setEmail('john2@doe.invalid'));

        // Test setting an invalid email
        $this->assertFalse($user->setEmail('invalid-email'));

        // TODO test whether duplicate checking works
    }

}