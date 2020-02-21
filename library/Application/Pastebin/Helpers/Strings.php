<?php

namespace Application\Pastebin\Helpers;

class Strings
{
    /**
     * Convert string to bytes.
     *
     * @param string $string
     *
     * @return int
     */
    public static function stringToBytes($string)
    {
        return round(strlen($string) / (pow(1024, 0) / pow(10, 0))) / pow(10, 0);
    }
}
