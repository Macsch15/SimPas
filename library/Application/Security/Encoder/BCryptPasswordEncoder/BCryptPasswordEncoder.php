<?php
namespace Application\Security\Encoder\BCryptPasswordEncoder;

use Application\Application;

class BCryptPasswordEncoder
{
    /**
    * Construct
    * 
    * @param Application $application
    * @return void
    */
    public function __construct()
    {
        if(function_exists('password_hash') === false) {
            require_once Application::makePath('library:Application:Security:Encoder:BCryptPasswordEncoder:password-compat.php');
        }
    }
}