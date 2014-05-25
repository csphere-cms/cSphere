<?php

/**
 * String Format
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
 * String Format
 *
 * @category  Core
 * @package   Strings
 * @author    Daniel Burke <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Format
{
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
        if (strlen($string.$placeholder) >= $count) {
            $string = substr($string, 0, $count) . $placeholder;
        }
        return $string; 
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
        if (strlen($string.$placeholder) >= $count) {
            $string = substr($string, 0, $count);
            $string = substr($string, 0, strrpos($string, ' ')) . $placeholder;
        }
        return $string;
    }   
}
