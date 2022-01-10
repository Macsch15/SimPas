<?php

namespace SimPas\Helpers;

class PasteId
{
    /**
     * @param $url
     * @return false|string
     */
    public static function getFromUrl($url)
    {
        $left_pos = strpos($url, 'paste/');

        if (!$left_pos) {
            return false;
        }

        $trim_left = substr($url, $left_pos + 6);

        if (strpos($trim_left, '/')) {
            $trim_left = substr($trim_left, null, strpos($trim_left, '/'));
        }

        if ($trim_left == null) {
            return false;
        }

        return trim($trim_left);
    }
}
