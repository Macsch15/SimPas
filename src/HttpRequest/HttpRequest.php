<?php

namespace SimPas\HttpRequest;

use SimPas\Security\DataFilters\PreDatabaseSave;

class HttpRequest
{
    /**
     * @param $field_name
     * @param false $restricted_characters
     * @return false|string
     */
    public static function post($field_name, bool $restricted_characters = false)
    {
        if (isset($_POST[$field_name]) === false) {
            return false;
        }

        if ($_POST[$field_name] == null) {
            return false;
        }

        $_POST[$field_name] = (new PreDatabaseSave())->filter($_POST[$field_name], $restricted_characters);

        return $_POST[$field_name];
    }

    /**
     * @param array $fields
     * @param null $required_field
     * @return bool
     */
    public static function isEmptyField(array $fields, $required_field = null): bool
    {
        if (!count($fields)) {
            return false;
        }

        $empty = false;

        foreach ($fields as $field) {
            if ($field === false && $field !== $required_field) {
                continue;
            }

            $field = preg_replace('/[\s\t\r\n]+/s', null, $field);

            if ($field == null) {
                $empty = true;
            }
        }

        return $empty;
    }

    /**
     * @return mixed|string
     */
    public static function getClientIpAddress()
    {
        $_ip = filter_var(getenv('REMOTE_ADDR'), FILTER_VALIDATE_IP);

        if ($_ip === false) {
            $_ip = '0.0.0.0';
        }

        return $_ip;
    }
}
