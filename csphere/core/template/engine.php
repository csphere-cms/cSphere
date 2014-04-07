<?php

/**
 * Defines all possible template engine use cases
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
 * Defines all possible template engine use cases
 *
 * @category  Core
 * @package   Template
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Engine
{
    /**
     * Name of active theme
     **/
    private static $_theme = '';

    /**
     * Parses only boxes in an array
     *
     * @param array  $boxes   Boxes as an array
     * @param string $content The content to put into the theme file
     *
     * @return array
     **/

    public static function boxes(array $boxes, $content)
    {
        $add   = [];
        $nodiv = ['nodiv' => true];

        //  Skip all parts except boxes
        foreach ($boxes AS $part) {

            $box       = $part['name'];
            $add[$box] = \csphere\core\template\CMD_Parse::box($part, $nodiv);
        }

        // Get page placeholders from hooks and append content
        $data             = \csphere\core\template\Hooks::export();
        $data['content'] .= $content;

        // Add boxes to data
        $data['boxes'] = $add;

        return $data;
    }

    /**
     * Search for template files in theme and plugin
     *
     * @param string $plugin   Name of the plugin
     * @param string $template Template file name without file ending
     *
     * @return array
     **/

    public static function source($plugin, $template)
    {
        // Get theme if it is not known yet
        if (self::$_theme == '') {

            $locator      = \csphere\core\service\Locator::get();
            $view         = $locator->load('view');
            self::$_theme = $view->getOption('theme');
        }

        // Check if theme overwrites the template file
        $target = new \csphere\core\themes\Checks(self::$_theme);
        $target->setTemplate($template, $plugin);

        $check = $target->existance();

        // Get template from plugin otherwise
        if ($check === false) {

            $target = new \csphere\core\plugins\Checks($plugin);
            $target->setTemplate($template);
        }

        // Load template file and fetch file content
        $file = $target->result();
        $file = file_get_contents($file);

        // Split template file content
        $tpl = \csphere\core\template\Prepare::template($file, $plugin);

        return $tpl;
    }

    /**
     * Parses a template file
     *
     * @param array $array Template file (part) as an array
     * @param array $data  Array with data to use in the template
     *
     * @return string
     **/

    public static function parse(array $array, array $data)
    {
        // Fill templates with their data
        try {
            $string = \csphere\core\template\Parse::template($array, $data);

        } catch (\Exception $exception) {

            // String must be a string in every case
            $string = '';

            // Continue to not cause further problems
            $cont = new \csphere\core\Errors\Controller($exception, true);

            unset($cont);
        }

        return $string;
    }
}
