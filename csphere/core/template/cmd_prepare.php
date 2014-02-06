<?php

/**
 * Contains template part prepare tools
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
 * Contains template part prepare tools
 *
 * @category  Core
 * @package   Template
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class CMD_Prepare
{
    /**
     * Enhance problem details for unknown calls
     *
     * @param string $name      Method name
     * @param array  $arguments Method parameters
     *
     * @throws \Exception
     *
     * @return void
     **/

    public static function __callStatic($name, array $arguments)
    {
        unset($arguments);

        throw new \Exception('Command unknown or damaged: ' . $name);
    }

    /**
     * Prepares boxes to make them usable
     *
     * @param array $part Placeholder cmd and key, maybe even more
     *
     * @throws \Exception
     *
     * @return array
     **/

    public static function box(array $part)
    {
        // Check for valid placeholder key data
        $target = isset($part['key']) ? explode('/', $part['key'], 3) : [];

        if (isset($target[1])) {

            // Get filename of plugin box
            $checks = new \csphere\core\plugins\Checks($target[0]);
            $checks->setRoute($target[1], true);
            $part['key'] = $checks->result();

            // Fallback if problems occur
            if ($part['key'] == '') {

                $part['cmd'] = 'text';
                $part['text'] = '';
                $part['name'] = '';

            } else {

                // Set name for identification
                $part['name'] = 'box_' . $target[0] . '_' . $target[1];
            }
        } else {

            throw new \Exception('BOX target missing: ' . $part['cmd']);
        }

        // Handle additional parameters
        $part['params'] = [];

        if (isset($target[2])) {

            $part['params'] = \csphere\core\url\Link::transform($target[2]);
        }

        return $part;
    }

    /**
     * Prepares subtemplates to make them usable
     *
     * @param array $part Placeholder cmd and key, maybe even more
     *
     * @throws \Exception
     *
     * @return array
     **/

    public static function tpl(array $part)
    {
        // Check for valid placeholder key data
        $replace = isset($part['key']) ? explode(' ', $part['key']) : [];
        $target  = explode('/', $replace[0], 2);

        // Prepare commands if there are any
        $cmds = [];

        if (isset($replace[1])) {

            $cmds   = [];
            $splits = count($replace);

            for ($i = 1; $i < $splits; $i++) {

                $split           = explode('=', $replace[$i], 2);
                $cmds[$split[0]] = isset($split[1]) ? $split[1] : '';
            }
        }

        if (isset($target[1])) {

            // Get filename of plugin template
            $checks = new \csphere\core\plugins\Checks($target[0]);
            $checks->setTemplate($target[1]);
            $file = $checks->result();

            // Get file content and prepare it
            $string = file_get_contents($file);
            $parts  = \csphere\core\template\Prepare::template(
                $string, $part['plugin'], $cmds
            );

            $part = ['cmd' => 'multi', 'value' => $parts];

        } else {

            throw new \Exception('TPL target missing: ' . $part['cmd']);
        }

        return $part;
    }

    /**
     * Allows for setting command details afterwards
     *
     * @param array $part Placeholder cmd and key, maybe even more
     * @param array $coms Array of commands to replace with others
     *
     * @throws \Exception
     *
     * @return array
     **/

    public static function com(array $part, array $coms)
    {
        $split = explode(' ', $part['key']);

        // Check for com details and data
        if (isset($split[1]) && isset($coms[$split[1]])) {

            // Text is a special case
            if ($split[0] == 'text') {

                $part = ['cmd' => 'text', 'text' => $coms[$split[1]]];

            } else {

                $part = \csphere\core\template\Prepare::hooks(
                    $split[0], $coms[$split[1]], $part['plugin'], []
                );
            }

        } else {

            throw new \Exception('COM data missing: ' . $part['key']);
        }

        return $part;
    }

    /**
     * Date needs hub parts
     *
     * @param array $part Placeholder cmd and key, maybe even more
     *
     * @return array
     **/

    public static function date(array $part)
    {
        $part = \csphere\core\template\Prepare::sub($part);

        return $part;
    }

    /**
     * Links to plugin actions
     *
     * @param array $part Placeholder cmd and key, maybe even more
     *
     * @return array
     **/

    public static function link(array $part)
    {
        // Check if a key is given and create the basic url
        $link = isset($part['key']) ? $part['key'] : '';

        $link = \csphere\core\url\Link::params($link);

        // Change to multi placeholder if at least one var is found
        if (strpos($link, '$') !== false) {

            $part = \csphere\core\template\Prepare::multi($link, 'url');

        } else {

            $part['cmd']  = 'text';
            $part['text'] = $link;
        }

        return $part;
    }

    /**
     * Share a link with external resources
     *
     * @param array $part Placeholder cmd and key, maybe even more
     *
     * @return array
     **/

    public static function share(array $part)
    {
        $dollar = rawurlencode('$');

        // Check if a key is given and create the basic url
        $share = isset($part['key']) ? $part['key'] : '';

        $share = \csphere\core\url\Link::params($share);

        // Add path to url and rawurlencode everything
        $share = \csphere\core\url\Link::share($share);

        $share = rawurlencode($share);

        // Change to multi placeholder if at least one var is found
        if (strpos($share, $dollar) !== false) {

            // Decode dollar sign to be found by multi method
            $share = str_replace($dollar, '$', $share);

            $part = \csphere\core\template\Prepare::multi($share, 'url');

        } else {

            $part['cmd']  = 'text';
            $part['text'] = $share;
        }

        return $part;
    }

    /**
     * Multi language replaces
     *
     * @param array $part Placeholder cmd and key, maybe even more
     *
     * @return array
     **/

    public static function lang(array $part)
    {
        // Check for translation requests to foreign plugins
        $target = explode('.', $part['key'], 2);

        if (isset($target[1])) {

            // Using other plugins then the current one or default is dangerous
            if ($target[0] != 'default' && $target[0] != $part['plugin']) {

                $msg = 'Plugin "' . $part['plugin'] . '" used a language-key '
                     . 'of a foreign plugin: ' . $part['key'];

                trigger_error($msg, E_USER_WARNING);
            }

            $part['plugin'] = $target[0];
            $part['key']    = $target[1];
        }

        // Get translation for requested key
        $lang = \csphere\core\translation\Fetch::key(
            $part['plugin'], $part['key']
        );

        // Change to multi placeholder if at least one var is found
        if (strpos($lang, '$') !== false) {

            $part = \csphere\core\template\Prepare::multi($lang, 'var');

        } else {

            $part['cmd']  = 'text';
            $part['text'] = $lang;
        }

        return $part;
    }
}