<?php
namespace Application\HttpRequest;

use Application\Security\DataFilters\PreDatabaseSave;

class HttpRequest
{
    /**
    * POST Request
    * 
    * @param string $field_name 
    * @return string|bool
    */
    public static function post($field_name, $restricted_characters = false)
    {
        // Element is not defined
        if(isset($_POST[$field_name]) === false) {
            return false;
        }

        // Element is empty
        if($_POST[$field_name] == null) {
            return false;
        }

        // Data filter
        $_POST[$field_name] = (new PreDatabaseSave)->filter($_POST[$field_name], $restricted_characters);

        return $_POST[$field_name];
    }

    /**
    * Checkbox
    * 
    * @param string $field_name
    * @param string $value
    * @return bool
    */
    public static function checkboxChecked($field_name, $value = null)
    {
        if(isset($_POST[$field_name]) === false) {
            return false;
        }

        if($_POST[$field_name] === 'on' || $_POST[$field_name] === '1' 
            || ($value !== null && $_POST[$field_name] === $value)
        ) {
            return true;
        }

        return false;
    }

    /**
    * Check whether given fields are not empty 
    * 
    * @param array $fields
    * @param string $required_field
    * @return bool
    */
    public static function isEmptyField(array $fields, $required_field = null)
    {
        if(!count($fields)) {
            return false;
        }

        $empty = false;

        foreach($fields as $field) {
            if($field === false && $field !== $required_field) {
                continue;
            }

            $field = preg_replace('/[\s\t\r\n]+/s', null, $field);

            if($field == null) {
                $empty = true;
            }
        }

        return $empty;
    }


    /**
    * Client IP (IPv4 / IPv6)
    * 
    * @return string
    */
    public static function getClientIpAddress()
    {
        $_ip = filter_var(getenv('REMOTE_ADDR'), FILTER_VALIDATE_IP);

        if($_ip === false) {
            $_ip = '0.0.0.0';
        }

        return $_ip;
    }
}
