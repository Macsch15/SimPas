<?php

namespace SimPas\Helpers;

class Strings
{
    /**
     * @param $string
     * @return float|int
     */
    public static function stringToBytes($string)
    {
        return round(strlen($string) / (pow(1024, 0) / pow(10, 0))) / pow(10, 0);
    }
}
