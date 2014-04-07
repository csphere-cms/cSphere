<?php

/**
 * Beware of the cookie monster *nom nom*
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   HTTP
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\http;

/**
 * Provides tools to work with cookies
 *
 * @category  Core
 * @package   HTTP
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Cookies
{
    /**
     * Retrieves the data stored in a cookie
     *
     * @param string $name Name of the cookie to retrieve
     *
     * @return string
     **/

    public static function get($name)
    {
        $string = \csphere\core\http\Input::get('cookie', $name);

        return $string;
    }

    /**
     * Sends a cookie limited to http(s)
     *
     * @param string  $name   Name of the cookie to set
     * @param string  $value  The value of the cookie
     * @param integer $expire Cookie expires at this unix timestamp
     * @param boolean $secure Only allow this cookie for https connections
     *
     * @return boolean
     **/

    public static function set($name, $value, $expire = 0, $secure = false)
    {
        $result = false;

        // Get request settings
        $request = \csphere\core\http\Request::get();

        $path = $request['dirname'];

        $domain = $request['dns'];

        // Check if secure is enabled and valid for usage
        if (empty($secure) || $request['protocol'] == 'https') {

            setcookie($name, $value, $expire, $path, $domain, $secure, true);

            $result = true;
        }

        return $result;
    }
}
