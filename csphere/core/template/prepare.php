<?php

/**
 * Contains template string prepare tools
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
 * Contains template string prepare tools
 *
 * @category  Core
 * @package   Template
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Prepare
{
    /**
     * List of commands that can pass to parse mode
     **/
    private static $_var = array('var' => 0, 'url' => 1, 'raw' => 2, 'form' => 3);

    /**
     * List of commands that need the plugin name
     **/
    private static $_plugin = array('com' => 0, 'lang' => 1, 'tpl' => 2);

    /**
     * List of commands that can be skipped at hooks
     **/
    private static $_skip = array('page' => 0, 'debug' => 1,);

    /**
     * Prepares nested array targets
     *
     * @param array $part Placeholder cmd and key, maybe even more
     *
     * @return array
     **/

    public static function sub(array $part)
    {
        $part['hub'] = $part['key'];
        $hub         = explode('.', $part['key'], 2);
        $part['key'] = $hub[0];
        $part['sub'] = isset($hub[1]) ? $hub[1] : '';

        return $part;
    }

    /**
     * Changes text to a multi placeholder array
     *
     * @param string $string The string to split in parts
     * @param string $cmd    The cmd to use for matches (defaults to "var")
     *
     * @return array
     **/

    public static function multi($string, $cmd = 'var')
    {
        $tokens = explode('$', $string);
        $parts  = array();

        // Every second array index should be a var element
        $tokens_c = count($tokens);

        for ($i = 0; $i < $tokens_c; $i+=2) {

            // Skip text placeholders with empty string
            if ($tokens[$i] != '') {

                $parts[] = array('cmd' => 'text', 'text' => $tokens[$i]);
            }

            // Check if there is another var element
            if (isset($tokens[($i + 1)])) {

                $add = array('cmd' => $cmd, 'key' => $tokens[($i + 1)]);

                // Var element is maybe targeting an array key
                $parts[] = self::sub($add);
            }
        }

        $part = array('cmd' => 'multi', 'value' => $parts);

        return $part;
    }

    /**
     * Split template file logic
     *
     * @param string $string Template file part as a string
     * @param string $plugin Name of the plugin for tpl files
     * @param array  $coms   Array of commands to replace with others
     *
     * @return array
     **/

    public static function template($string, $plugin = '', array $coms = array())
    {
        // Add form end placeholder to form closing tags
        $pattern = "'((?:\{\* form end \*\}[\s]*)*\<\/form\>)'sS";
        $replace = '{* form end *}' . "\n" . '</form>';
        $string  = preg_replace($pattern, $replace, $string);

        // Split string into an array of foreach and if parts
        $pattern  = "'\{\* (?P<cmd>foreach|if)"
                  . " (?P<key>[\S]+?)"
                  . "(?: (?P<equal>\=\=|\!\=|\<|\>) \'(?P<cond>[\S]*?)\'){0,1} \*\}"
                  . "(?P<value>.*?)[\s]*"
                  . "(?:\{\* else (?P=key) \*\}(?P<else>.*?)[\s]*){0,1}"
                  . "\{\* (end)(?P=cmd) (?P=key) \*\}"
                  . "'sS";
        $template = preg_split($pattern, $string, -1, PREG_SPLIT_DELIM_CAPTURE);

        $parts = count($template);

        $new = self::placeholders($template[0], $plugin, $coms);

        // Parts: i1 = cmd, i2 = key, i3 = equal i4 = cond, i5 = value, i6 = else
        for ($i = 1; $i < $parts; $i++) {

            // Nesting of foreach and if tags
            if ($template[$i] == 'foreach' OR $template[$i] == 'if') {

                $split = self::template($template[($i + 4)], $plugin, $coms);
                $else  = self::template($template[($i + 5)], $plugin, $coms);

                $next = array('cmd'   => $template[$i],
                              'key'   => $template[($i + 1)],
                              'equal' => $template[($i + 2)],
                              'cond'  => $template[($i + 3)],
                              'value' => $split,
                              'else'  => $else);

                $new[] = self::sub($next);

                // Add the part next to the nested content
                $add = self::placeholders($template[($i + 7)], $plugin, $coms);

                $new = array_merge($new, $add);

                // Skip end commands
                $i += 7;
            }
        }

        return $new;
    }

    /**
     * Split template file placeholders
     *
     * @param string $string Template file part as a string
     * @param string $plugin Name of the plugin for tpl files
     * @param array  $coms   Array of commands to replace with others
     *
     * @return array
     **/

    public static function placeholders($string, $plugin, array $coms = array())
    {
        // Split string into an array of placeholders and content
        $search   = "'\{\* (?P<cmd>[\S]+?)"
                  . " (?P<key>.*?) \*\}"
                  . "'S";
        $template = preg_split($search, $string, -1, PREG_SPLIT_DELIM_CAPTURE);

        $new = array();

        // Skip text placeholders with empty string
        if ($template[0] != '') {

            $new[] = array('cmd' => 'text', 'text' => $template[0]);
        }

        $traps = count($template);

        // Content parts: j1 = cmd, j2 = key, j3 = value
        for ($j = 1; $j < $traps; $j++) {

            // Run hooks and add array elements afterwards
            try {
                $new[] = self::hooks(
                    $template[$j], $template[($j + 1)], $plugin, $coms
                );
            }
            catch (\Exception $exception) {

                // Continue to not cause further problems
                $cont = new \csphere\core\Errors\Controller($exception, true);

                unset($cont);
            }

            // Skip text placeholders with empty string
            if ($template[($j + 2)] != '') {

                $new[] = array('cmd' => 'text', 'text' => $template[($j + 2)]);
            }

            // Skip end of placeholder
            $j += 2;
        }

        return $new;
    }

    /**
     * Hooks for placeholders
     *
     * @param string $cmd    Command of placeholder
     * @param string $key    Key data of placeholder
     * @param string $plugin Name of the plugin for tpl files
     * @param array  $coms   Array of commands to replace with others
     *
     * @return array
     **/

    public static function hooks($cmd, $key, $plugin, array $coms)
    {
        // Combine array and add plugin if required by placeholder
        $next = array('cmd' => $cmd, 'key' => $key);

        if (isset(self::$_plugin[$cmd])) {

            $next['plugin'] = $plugin;
        }

        // Run sub array for vars or run cmd prepare
        if (isset(self::$_var[$cmd])) {

            $next = self::sub($next);

        } elseif (!isset(self::$_skip[$cmd])) {

            $next = \csphere\core\template\CMD_Prepare::$cmd($next, $coms);
        }

        return $next;
    }
}