<?php

/**
 * Contains theme specific tools
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
 * Contains theme specific tools
 *
 * @category  Core
 * @package   Template
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Theme
{
    /**
     * Convert array of source files to string
     *
     * @param string $type    Must be javascripts or stylesheets
     * @param array  $sources File sources as an array
     *
     * @return string
     **/

    private static function _src($type, array $sources)
    {
        $string = '';

        // Set start and end tag for javascripts and stylesheets
        if ($type == 'stylesheets') {

            $tag1 = '<link href="';
            $tag2 = '" rel="stylesheet" type="text/css">';

        } else {

            $tag1 = '<script src="';
            $tag2 = '" type="text/javascript"></script>';

        }

        // Convert arrays to strings
        foreach ($sources AS $file) {

            $string .= $tag1 . $file . $tag2 . "\n";
        }

        return $string;
    }

    /**
     * Light version of combine features for themes
     *
     * @param array $array Template file as an array
     *
     * @return array
     **/

    private static function _light(array $array)
    {
        // Combine array of parts
        $result = [];

        foreach ($array AS $part) {

            // Leave text and page placeholders untouched
            if ($part['cmd'] == 'text' || $part['cmd'] == 'page') {

                $result[] = $part;

            } else {

                // Everything else can be transformed
                $cmd = $part['cmd'];

                $string = \csphere\core\template\CMD_Parse::$cmd($part, []);

                $result[] = ['cmd' => 'text', 'text' => $string];
            }
        }

        return $result;
    }

    /**
     * Get boxes out of a prepared theme array
     *
     * @param array $theme Theme after prepare is used on it
     *
     * @return array
     **/

    public static function boxes(array $theme)
    {
        $add = [];

        //  Skip all parts except boxes
        foreach ($theme AS $part) {

            if ($part['cmd'] == 'box') {

                $add[] = $part;
            }
        }

        return $add;
    }

    /**
     * Parses a theme file
     *
     * @param array  $theme   Theme content as an array
     * @param string $content The content to put into the theme file
     *
     * @throws \Exception
     *
     * @return string
     **/

    public static function parse(array $theme, $content)
    {
        // Replace everything except for page placeholders
        $theme = self::_light($theme);

        // Get page placeholders from hooks and append content
        $data = \csphere\core\template\Hooks::export();

        $data['debug'] = '<div id="csphere_debug">' . $data['debug'] . '</div>';

        $start           = '<div id="csphere_content">' . $data['content'];
        $data['content'] = $start . $content . '</div>';

        // Javascript and stylesheet arrays to strings
        $data['javascripts'] = self::_src('javascripts', $data['javascripts']);
        $data['stylesheets'] = self::_src('stylesheets', $data['stylesheets']);

        // Replace page placeholders
        $result = '';

        foreach ($theme AS $part) {

            if ($part['cmd'] == 'page') {

                $result .= isset($data[$part['key']]) ? $data[$part['key']] : '';

            } elseif ($part['cmd'] == 'text') {

                $result .= $part['text'];

            } else {
                throw new \Exception('Command not found: ' . $part['cmd']);
            }
        }

        return $result;
    }

    /**
     * Corrections for theme files to make them preparable
     *
     * @param string $string Theme content as a string
     * @param string $theme  Theme directory as a string
     *
     * @return array
     **/

    public static function prepare($string, $theme)
    {
        // Try to find or attach room for javascript and stylesheets
        if (strpos($string, '{* page stylesheets *}') === false) {

            $change = '{* page stylesheets *}</head>';
            $string = str_ireplace('</head>', $change, $string);
        }

        $generator = '<meta name="generator" content="cSphere">'
                   . "\n" . '</head>';
        $string    = str_ireplace('</head>', $generator, $string);

        if (strpos($string, '{* page javascripts *}') === false) {

            $change = '{* page javascripts *}</body>';
            $string = str_ireplace('</body>', $change, $string);
        }

        // Check for debug placeholder
        $debug = '';

        if (strpos($string, '{* page debug *}') === false) {

            $debug = "\n" . '{* page debug *}';
        }

        $change = "<body\\1>" . $debug;
        $string = preg_replace('=\<body(.*?)\>=si', $change, $string, 1);

        // Repair html link tag href attributes
        $search = "=\<link(.*?)href\=\"(?!http|\/)(.*?)\"(.*?)\>=i";
        $change = "<link\\1href=\"" . $theme . "\\2\"\\3>";
        $string = preg_replace($search, $change, $string);

        // Repair html background and src attributes
        $search = "=(background|src)\=\"(?!http|\/)(.*?)\"=i";
        $change = "\\1=\"" . $theme . "\\2\"";
        $string = preg_replace($search, $change, $string);

        // Placeholder detection
        $result = \csphere\core\template\Prepare::placeholders((string)$string, '');

        return $result;
    }
}
