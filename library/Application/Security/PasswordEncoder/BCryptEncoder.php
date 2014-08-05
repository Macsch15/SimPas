<?php
namespace Application\Security\PasswordEncoder;

use Application\Application;

class BCryptEncoder
{
    /**
     * Construct
     * 
     * @return void
     */
    public function __construct()
    {
        if(version_compare(PHP_VERSION, '5.0.0', '>=')) {
            // Include password-compat
            require_once Application::makePath('library:Application:Security:PasswordEncoder:PasswordCompat.php');
        }
    }

    /**
     * Encode password
     * 
     * @param string $password
     * @param array $options
     * @return string|bool
     */
    public function passwordHash($password, array $options = [])
    {
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    /**
     * Password verify
     * 
     * @param string $raw_password
     * @param string $hash 
     * @return bool
     */
    public function passwordVerify($raw_password, $hash)
    {
        return password_verify($raw_password, $hash);
    }

    /**
     * Determine if the password hash needs to be rehashed according to the options provided
     * 
     * @param string $hash
     * @param array $options 
     * @return bool
     */
    public function passwordNeedsRehash($hash, array $options = [])
    {
        return password_needs_rehash($hash, PASSWORD_BCRYPT, $options);
    }
}
