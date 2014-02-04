<?php

/**
 * Allows for adding content to theme output in fixed ways
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
 * Allows for adding content to theme output in fixed ways
 *
 * @category  Core
 * @package   Template
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Hooks
{
    /**
     * List of handled page placeholders
     **/

    private static $_data = array('action'      => '',
                                  'breadcrumb'  => '',
                                  'debug'       => '',
                                  'javascripts' => array(),
                                  'plugin'      => '',
                                  'stylesheets' => array(),
                                  'title'       => 'cSphere');

    /**
     * Generate website title
     *
     * @param string $plugin Plugin name
     * @param string $action Action name
     *
     * @return string
     **/

    private static function _title($plugin, $action)
    {
        $title = self::$_data['title'];

        // Get translation for adding plugin and action to title
        if (!empty($plugin)) {

            $add = \csphere\core\translation\Fetch::key($plugin, $plugin);

            $title .= ' - ' . $add;

            // Dispatcher should handle everything by itself
            if (!empty($action) && $action != 'dispatch') {

                // Check if action is translated somewhere
                $fallback = \csphere\core\translation\Fetch::fallback(
                    $plugin, $action
                );

                // Only add action if a fallback was found
                if ($fallback != '') {

                    $title .= ' - ' . \csphere\core\translation\Fetch::key(
                        $fallback, $action
                    );
                }
            }
        }

        return $title;
    }

    /**
     * Collect startup file entries
     *
     * @return void
     **/

    private static function _startup()
    {
        // Try to load startup info from cache
        $loader = \csphere\core\service\Locator::get();

        $cache = $loader->load('cache');

        $startup = $cache->load('startup_plugins');

        // Get startup info from plugin metadata otherwise
        if ($startup == false) {

            $metadata = new \csphere\core\plugins\Metadata();
            $startup  = $metadata->startup();

            $cache->save('startup_plugins', $startup);
        }

        // Add startup entries for javascript and stylesheet
        foreach ($startup['javascript'] AS $script) {

            self::javascript($script['plugin'], $script['file'], $script['top']);
        }

        foreach ($startup['stylesheet'] AS $style) {

            self::stylesheet($style['plugin'], $style['file'], $style['top']);
        }
    }

    /**
     * Append javascript files
     *
     * @param string  $plugin Plugin that the file belongs to
     * @param string  $file   File name with file ending
     * @param boolean $top    Important files can be loaded first
     *
     * @return boolean
     **/

    public static function javascript($plugin, $file, $top = false)
    {
        // Alter file path so that it will work
        $target = $file;

        if (strpos($file, '://') === false) {

            $target = \csphere\core\http\Request::get('dirname')
                    . 'csphere/plugins/' . $plugin . '/javascripts/' . $file;
        }

        $type = 'javascripts';

        // Check for top param
        if ($top === false) {

            self::$_data[$type] = array_merge(self::$_data[$type], array($target));

        } else {

            self::$_data[$type] = array_merge(array($target), self::$_data[$type]);
        }

        return true;
    }

    /**
     * Append stylesheet files
     *
     * @param string  $plugin Plugin that the file belongs to
     * @param string  $file   File name with file ending
     * @param boolean $top    Important files can be loaded first
     *
     * @return boolean
     **/

    public static function stylesheet($plugin, $file, $top = false)
    {
        // Alter file path so that it will work
        $target = $file;

        if (strpos($file, '://') === false) {

            $target = \csphere\core\http\Request::get('dirname')
                    . 'csphere/plugins/' . $plugin . '/stylesheets/' . $file;
        }

        $type = 'stylesheets';

        // Check for top param
        if ($top === false) {

            self::$_data[$type] = array_merge(self::$_data[$type], array($target));

        } else {

            self::$_data[$type] = array_merge(array($target), self::$_data[$type]);
        }

        return true;
    }

    /**
     * Set route for target information
     *
     * @param string $plugin Plugin
     * @param string $action Action
     *
     * @return boolean
     **/

    public static function route($plugin, $action)
    {
        // Set plugin and action
        self::$_data['plugin'] = $plugin;
        self::$_data['action'] = $action;

        return true;
    }

    /**
     * Prepend content with breadcrumb navigation
     *
     * @param string $string Breadcrumb as string
     *
     * @return boolean
     **/

    public static function breadcrumb($string)
    {
        self::$_data['breadcrumb'] = $string;

        return true;
    }

    /**
     * Set page title
     *
     * @param string  $title  Title text
     * @param boolean $append Keep current title and add new text
     *
     * @return boolean
     **/

    public static function title($title, $append = true)
    {

        // Append or set title text
        if ($append === true) {

            self::$_data['title'] .= ' - ' . $title;

        } else {

            self::$_data['title'] = $title;
        }

        return true;
    }

    /**
     * Export debug data only
     *
     * @return string
     **/

    public static function debug()
    {
        $toolbar = new \csphere\core\debug\Toolbar();
        $result  = $toolbar->content();

        return $result;
    }

    /**
     * Export data array for later usage e.g. by theme replacements
     *
     * @return array
     **/

    public static function export()
    {
        // Fetch view options
        $loader = \csphere\core\service\Locator::get();
        $view   = $loader->load('view');
        $ajax   = (int)$view->getOption('links_ajax');
        $debug  = $view->getOption('debug');

        // add startup files
        self::_startup();

        // Add debug toolbar if activated
        if ($debug == true) {

            self::$_data['debug'] = self::debug();
        }

        // Get copy of data array and remove plugin and action in it
        $data   = self::$_data;
        $plugin = $data['plugin'];
        $action = $data['action'];

        unset($data['plugin'], $data['action']);

        // Get website title
        $data['title'] = self::_title($plugin, $action);

        // Generate hidden fields with plugin and action name
        $dirname         = \csphere\core\http\Request::get('dirname');
        $data['content'] = '<input type="hidden" name="csphere_plugin" value="'
                         . $plugin . '">' . "\n"
                         . '<input type="hidden" name="csphere_action" value="'
                         . $action . '">' . "\n"
                         . '<input type="hidden" name="csphere_ajax" value="'
                         . $ajax . '">' . "\n"
                         . '<input type="hidden" name="csphere_dir" value="'
                         . $dirname . '">' . "\n";

        // Append breadcrumb navigation
        $data['content'] .= $data['breadcrumb'] . "\n";

        return $data;
    }
}