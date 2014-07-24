<?php
use Application\Security\PasswordEncoder\BCryptEncoder;

class BCryptPasswordTest extends PHPUnit_Framework_TestCase
{
    public function testBcryptPassword()
    {
        $bcrypt = new BCryptEncoder();
        $encoded_password = $bcrypt->passwordHash('My password test');
        $expected_result = '$2y$10$LGegmgpTz1zv1y.NIV0OluE6dLUWkKtfQD97I9Dwt6DTuyMzH5HrC';

        $this->assertTrue($bcrypt->passwordVerify('My password test', $expected_result));
    }
}
