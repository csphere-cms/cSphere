<?php

/**
 * Work with one-way encryption
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Authentication
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\authentication;

/**
 * Work with one-way encryption
 *
 * @category  Core
 * @package   Authentication
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Password
{
    /**
     * Hash a string with an algorithm
     *
     * @param string  $string Raw string
     * @param integer $cost   Cost between 4 and 31, higher = better but slower
     *
     * @return string
     **/

    public static function hash($string, $cost = 10)
    {
        // Check if cost is within limits
        if ($cost < 4 || $cost > 31) {

            $cost = 10;
        }

        // Create salt string for crypt function
        $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
        $salt = base64_encode($salt);
        $salt = str_replace('+', '.', $salt);

        // Set hash type (blowfish) and cost
        $salt = '$2y$' . $cost . '$' . $salt . '$';

        // Get hashed string
        $hash = crypt($string, $salt);

        return $hash;
    }

    /**
     * Compare a string with a given password
     *
     * @param string $string Raw string
     * @param string $hash   Hashed password to compare with
     *
     * @return boolean
     **/

    public static function compare($string, $hash)
    {
        // Use hash as salt since crypt is a one-way algorithm
        $verify = crypt($string, $hash);

        // Variable verify should contain the hash
        $result = ($verify == $hash) ? true : false;

        return $result;
    }
}