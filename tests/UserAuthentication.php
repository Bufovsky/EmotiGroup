<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Summary of UserAuthentication
 */
abstract class UserAuthentication extends WebTestCase
{
    /**
     * Summary of createUser
     * @return mixed
     */
    public static function generateToken() 
    {
        $data = array('username' => 'email@alias.pl', 'password' => 'password');
        
        return self::$kernel->getContainer()
                            ->get('lexik_jwt_authentication.encoder')
                            ->encode($data);
    }
}