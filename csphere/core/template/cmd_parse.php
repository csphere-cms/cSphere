<?php

/**
 * Contains template string replace tools
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
 * Contains template string replace tools
 *
 * @category  Core
 * @package   Template
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class CMD_Parse
{
    /**
     * Store view driver for boxes
     **/
    private static $_view = null;

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

        throw new \Exception('Command unknown: ' . $name);
    }

    /**
     * Include prepared boxes
     *
     * @param array $part Placeholder cmd and key, maybe even more
     * @param array $data Array with data to use in the template
     *
     * @return string
     **/

    public static function box(array $part, array $data)
    {
        // Get settings if not done yet
        if (self::$_view == '') {

            $loader      = \csphere\core\service\Locator::get();
            self::$_view = $loader->load('view');
        }

        // Set box params for this box
        \csphere\core\http\Input::setBox($part['params']);

        // Clear current box to not end in a loop
        self::$_view->box(true);

        \csphere\core\router\Sandbox::run($part['key']);

        $box = self::$_view->box();

        // Add box name as div if not declined
        if (!isset($data['nodiv'])) {

            $div = '<div class="' . $part['name'] . '">';
            $box = $div . $box . '</div>';
        }

        return $box;
    }

    /**
     * Date and time replaces extendable by zone
     *
     * @param array $part Placeholder cmd and key, maybe even more
     * @param array $data Array with data to use in the template
     *
     * @return string
     **/

    public static function date(array $part, array $data)
    {
        $part = \csphere\core\template\Parse::sub($part, $data);

        // Data must be an unix timestamp of type integer
        $unix = (int)$part['data'];

        $date = \csphere\core\date\Unixtime::userDateTime($unix);

        // @TODO: Should be configurable later on
        $result = $date->format('Y-m-d')
                . ' at '
                . $date->format('H:i:s');

        return $result;
    }

    /**
     * Debug info for template data
     *
     * @param array $part Placeholder cmd and key, maybe even more
     * @param array $data Array with data to use in the template
     *
     * @return string
     **/

    public static function debug(array $part, array $data)
    {
        // Get target array data
        $key = explode('.', $part['key']);

        foreach ($key AS $target) {

            $data = isset($data[$target]) ? $data[$target] : null;
        }

        // Generate output and format it
        if ($data != null) {
            ob_start();
            var_dump($data);
            $content = ob_get_clean();
            $content = nl2br($content);

        } else {

            $content = 'Error: No data found';
        }

        $info   = 'Debug info for "' . $part['key'] . '":<br />' . "\n";
        $result = $info . $content;

        return $result;
    }

    /**
     * Placeholder right before form ends
     *
     * @param array $part Placeholder cmd and key, maybe even more
     * @param array $data Array with data to use in the template
     *
     * @return string
     **/

    public static function form(array $part, array $data)
    {
        unset($part, $data);

        // Add hidden input to catch form submit
        $result = '<input type="hidden" name="csphere_form" value="1" />';

        return $result;
    }
}