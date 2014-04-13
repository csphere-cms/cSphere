<?php

/**
 * String Helper
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Strings
 * @author    Daniel Burke <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\strings;

/**
 * String Helper
 *
 * @category  Core
 * @package   Strings
 * @author    Daniel Burke <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Helper
{

    /**
     * Validates an email address: tests if a string represents a valid email.
     *
     * @param string $string the input string
     *
     * @return bool
     **/
    public static function isEmail($string)
    {
        return !(filter_var($string, FILTER_VALIDATE_EMAIL) === false);
    }

    /**
     * Validates an IP4 address: tests if a string represents a valid IP.
     *
     * @param string $string the input string
     *
     * @return bool
     **/
    public static function isIp4($string)
    {
        return !(filter_var($string, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
            === false);
    }

    /**
     * Validates an IP6 address: tests if a string represents a valid IP.
     *
     * @param string $string the input string
     *
     * @return bool
     **/
    public static function isIp6($string)
    {
        return !(filter_var($string, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)
            === false);
    }
    
    /**
     * Validates an URL address: tests if a string represents a valid URL.
     *
     * @param string $string the input string
     *
     * @return bool
     **/
    public static function isUrl($string)
    {
        return !(filter_var($string, FILTER_VALIDATE_URL) === false);
    }

    /**
     * Validates a numeric: tests if a string represents Numeric.
     *
     * @param string $string the input string
     *
     * @return bool
     **/

    public static function isNumeric($string)
    {
           return !(filter_var($string, FILTER_VALIDATE_INT) === false);
    }
    /**
     * Validates a hexadecimal code: tests if a string is a valid hexadecimal
     * HTML color.
     *
     * @param string $string the input string
     *
     * @return bool
     **/
    public static function isHexColor($string)
    {
        return preg_match('/^#[a-f0-9]{6}$/i', $string);
    }
    
    /**
     * Validates a date: tests if a string represents a valid date.
     *
     * @param string $string the input string
     *
     * @return bool
     **/
    public static function isDate($string)
    {
        $date = strtotime($string);
        if (!filter_var($date, FILTER_VALIDATE_INT)) {
            return false;
        }

        $month = date('m', $date);
        $day = date('d', $date);
        $year = date('Y', $date);

        if (checkdate($month, $day, $year)) {
            return true;
        }
        return false;
    } 

    /**
     * Shortens a string.
     *
     * @param string $string      the input string
     * @param int    $count       the final length of the string
     * @param string $placeholder the placeholder string
     *
     * @return string the short string
     **/        
    public static function doStraightShorten($string, $count, $placeholder = '...')
    {
        return substr($string, 0, ($count*-1)) . $placeholder;
    }    

    /**
     * Shortens a string.
     *
     * @param string $string      the input string
     * @param int    $count       the final length of the string
     * @param string $placeholder the placeholder string
     *
     * @return string the short string without breaking a word
     **/       
    public static function doShorten($string, $count, $placeholder = ' ...')
    {
        if (strlen($string) > $count) {
            $string = substr($string, 0, $count);
            $string = substr($string, 0, strrpos($string, ' ')) . $placeholder;
        }
        return $string;
    }  
    
}