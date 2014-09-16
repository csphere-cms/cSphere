<?php

/**
 * Contains template string parse tools
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Template
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\template;

/**
 * Contains template string parse tools
 *
 * @category  Core
 * @package   Template
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Parse
{
    /**
     * List of commands that can contain a variable
     **/
    private static $_var = ['var' => 0, 'url' => 1, 'raw' => 2];

    /**
     * Adds requested data as a key to the part array after some checks
     *
     * @param array $part Template file part as an array
     * @param array $data Array with data to use in the template
     *
     * @return array
     **/

    public static function sub(array $part, array $data)
    {
        // Set requested data as new array element
        if ($part['sub'] == '' && isset($data[$part['key']])) {

            $part['data'] = $data[$part['key']];

        } elseif (isset($data[$part['key']][$part['sub']])) {

            $part['data'] = $data[$part['key']][$part['sub']];

        } else {

            $part['data'] = '';

            // Throwing an exception does not make sense here
            $msg = 'CMD "' . $part['cmd'] . '" without data: ' . $part['hub'];
            trigger_error($msg, E_USER_WARNING);
        }

        return $part;
    }

    /**
     * Parses nested foreach loops
     *
     * @param array $part Template file part as an array
     * @param array $data Array with data to use in the template
     *
     * @return string
     **/

    private static function _loops(array $part, array $data)
    {
        $part  = self::sub($part, $data);
        $nest  = $part['sub'];
        $value = [];
        $all   = '<!-- foreach ' . $part['hub'] . ' -->';

        if ($part['sub'] == '') {

            $nest = $part['key'];
        }

        if (is_array($part['value'])) {

            $value = $part['value'];
        }

        // Check if required data exists
        if ($part['data'] != []) {

            // Loop through data array
            foreach ($part['data'] AS $set) {

                $set = array_merge($data, [$nest => $set]);

                $all .= self::template($value, $set);
            }

        } elseif ($part['else'] != []) {

            $all .= '<!-- else ' . $part['hub'] . ' -->';

            $all .= self::template($part['else'], $part['data']);
        }

        $all .= "\n" . '<!-- endforeach ' . $part['hub'] . ' -->';

        return $all;
    }

    /**
     * Checks if data matches the given key
     *
     * @param array $part Template file part as an array
     *
     * @return boolean
     **/

    private static function _math(array $part)
    {
        $result = false;

        // Check condition against data array
        if (($part['equal'] == '==' && $part['cond'] == $part['data'])
            || ($part['equal'] == '!=' && $part['cond'] != $part['data'])
            || ($part['equal'] == '>' && (int)$part['cond'] < $part['data'])
            || ($part['equal'] == '<' && (int)$part['cond'] > $part['data'])
        ) {

            $result = true;
        }

        return $result;
    }

    /**
     * Parses nested conditions
     *
     * @param array $part Template file part as an array
     * @param array $data Array with data to use in the template
     *
     * @return string
     **/

    private static function _conditions(array $part, array $data)
    {
        $part  = self::sub($part, $data);
        $check = self::_math($part);
        $value = [];
        $all   = '<!-- if ' . $part['hub'] . ' -->';

        if (is_array($part['value'])) {

            $value = $part['value'];
        }

        // Only parse sub content if check is true
        if ($check == true) {

            $all .= self::template($value, $data);

        } elseif ($part['else'] != []) {

            $all .= '<!-- else ' . $part['hub'] . ' -->';

            $all .= self::template($part['else'], $data);
        }

        $all .= '<!-- endif ' . $part['hub'] . ' -->';

        return $all;
    }

    /**
     * Add required var content from data array
     *
     * @param array $part Template file part as an array
     * @param array $data Array with data to use in the template
     *
     * @return string
     **/

    private static function _vars(array $part, array $data)
    {
        $part = self::sub($part, $data);

        if (is_array($part['data'])) {

            $escape = '';

            // Throwing an exception does not make sense here
            $msg = 'CMD "' . $part['cmd'] . '" is an array: ' . $part['hub'];
            trigger_error($msg, E_USER_WARNING);

        } elseif ($part['cmd'] == 'url') {

            // CMD url needs to be rawurlencoded
            $escape = rawurlencode($part['data']);

        } elseif ($part['cmd'] == 'var') {

            // HHVM does not support ENT_SUBSTITUTE and ENT_HTML5 yet
            $escape = htmlspecialchars($part['data'], ENT_QUOTES, 'UTF-8', false);

            // @TODO Maybe another way ??
            if (isset($data['action']) && $data['action'] != "edit") {
                $escape = nl2br($escape, false);
            }

        } else {

            // Raw data is not escaped
            $escape = $part['data'];
        }

        return $escape;
    }

    /**
     * Processes a single placeholder
     *
     * @param array $part Template file part as an array
     * @param array $data Array with data to use in the template
     *
     * @return string
     **/

    private static function _advanced(array $part, array $data)
    {
        $cmd = $part['cmd'];

        // Logic parts first
        if ($cmd == 'if') {

            $string = self::_conditions($part, $data);

        } elseif ($cmd == 'foreach') {

            $string = self::_loops($part, $data);

        } elseif ($cmd == 'multi') {

            $string = self::template($part['value'], $data);

        } elseif ($cmd == 'text') {

            $string = $part['text'];

        } elseif (isset(self::$_var[$cmd])) {

            $string = self::_vars($part, $data);

        } else {

            // Transform remaining CMD calls
            $string = \csphere\core\template\CMD_Parse::$cmd($part, $data);
        }

        return $string;
    }

    /**
     * Combine template file content for usage
     *
     * @param array $array Template file (part) as an array
     * @param array $data  Array with data to use in the template
     *
     * @return string
     **/

    public static function template(array $array, array $data)
    {
        // Combine array of parts to a string
        $string = '';

        foreach ($array AS $part) {

            $string .= self::_advanced($part, $data);
        }

        return $string;
    }
}
