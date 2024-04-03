<?php

namespace A11yBuddy\Utils;

/**
 * A utility class for generating random strings.
 */
class RandomString
{

    private static string $lowercaseAndNumbers = '0123456789abcdefghijklmnopqrstuvwxyz';

    /**
     * Generates a random string of the given length. The string will contain only lowercase letters and numbers.
     * 
     * @param int $length The length of the string to generate.
     * 
     * @return string The generated random string.
     */
    public static function randomIdString(int $length = 16): string
    {
        $result = '';
        $slices = str_split(self::$lowercaseAndNumbers);
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $result .= $slices[array_rand($slices)];
        }

        return $result;
    }

}