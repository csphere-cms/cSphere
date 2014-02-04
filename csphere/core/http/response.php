<?php

/**
 * Stores response data and headers
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
 * Stores response data and headers
 *
 * @category  Core
 * @package   HTTP
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Response
{
    /**
     * Array with headers to be send
     **/
    private static $_headers = array();

    /**
     * Store if send was already called
     **/
    private static $_status = false;

    /**
     * Wether to manually compress the output
     **/
    private static $_zlib = false;

    /**
     * Send headers and echo content
     *
     * @param string $string Content as string
     *
     * @return string
     **/

    public static function send($string)
    {
        // Update status
        self::$_status = true;

        // Send headers first as they are most important
        if (is_array(self::$_headers)) {

            foreach (self::$_headers AS $name => $content) {

                header($name . ': ' . $content);
            }
        }

        // Response is always ok
        header(':', true, 200);

        // Enable zlib output compression if enabled
        if (!empty(self::$_zlib) && extension_loaded('zlib')) {

            // This is preferred over using ob_gzhandler
            ini_set('zlib.output_compression', 1);
        }

        // Content should follow for completion
        echo $string;
    }

    /**
     * Allows for a new header to be stored
     *
     * @param string  $name    Name of header, e.g. Content-Type
     * @param string  $content Content of header, e.g. text/html
     * @param boolean $replace Replace earlier entries with same name
     *
     * @throws \Exception
     *
     * @return boolean
     **/

    public static function header($name, $content, $replace = false)
    {
        // Check if the header is already stored
        if (!isset(self::$_headers[$name]) || $replace == true) {

            self::$_headers[$name] = $content;
        } else {

            throw new \Exception('This header was already set');
        }

        return true;
    }

    /**
     * Allows for compression changes
     *
     * @param boolean $zlib Defines if output gets manually compressed
     *
     * @return boolean
     **/

    public static function compression($zlib)
    {
        self::$_zlib = (boolean)$zlib;

        return true;
    }

    /**
     * Checks if content was already send
     *
     * @return boolean
     **/

    public static function status()
    {
        return self::$_status;
    }
}