<?php

/**
 * Travel between nested actions in a plugin
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
 * Travel between nested actions in a plugin
 *
 * @category  Core
 * @package   Template
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Breadcrumb
{
    /**
     * There must be at least a plugin
     **/
    private $_plugin = '';

    /**
     * Road from second to last entry
     **/
    private $_road = array();

    /**
     * Plugin is important for links and language
     *
     * @param string $plugin Plugin name
     * @param string $link   Link on plugin name that targets the given action
     *
     * @return \csphere\core\template\Breadcrumb
     **/

    public function __construct($plugin)
    {
        // Set plugin
        $this->_plugin = $plugin;
    }

    /**
     * Change the plugin and add a link with plugin name text to the action
     *
     * @param string $plugin Plugin name
     * @param string $action Action name
     *
     * @return boolean
     **/

    public function plugin($plugin, $action)
    {
        // Switch plugin
        $this->_plugin = $plugin;

        // Get plugin translation
        $text = \csphere\core\translation\Fetch::key($plugin, $plugin);

        $this->add($action, '', $text);

        return true;
    }

    /**
     * Adds a new part to the breadcrumb
     *
     * @param string $key  Key name for plugin action
     * @param string $link Link as slash formated url if it is not /plugin/key
     * @param string $text Text to show if it differs from translated key name
     *
     * @return boolean
     **/

    public function add($key, $link = '', $text = '')
    {
        // If no text is set the key must be fetched from translation
        if ($text == '') {

            // Check if action is translated somewhere
            $fallback = \csphere\core\translation\Fetch::fallback(
                $this->_plugin, $key
            );

            // Only add action if a fallback was found
            if ($fallback != '') {

                $text = \csphere\core\translation\Fetch::key($fallback, $key);

            } else {

                $text = '[undefined]';
            }
        }

        // When no link is given the key is used
        if ($link == '') {

            $link = $this->_plugin . '/' . $key;
        }

        $url = \csphere\core\url\Link::params($link);

        $this->_road[] = array('key' => $key, 'text' => $text, 'url' => $url);

        return true;
    }

    /**
     * Build navigation and prepend it at content
     *
     * @return boolean
     **/

    public function trace()
    {
        // Get loader and view
        $loader = \csphere\core\service\Locator::get();
        $view   = $loader->load('view');

        // Format data for template usage
        $data = array('breadcrumb' => $this->_road);

        // Send data to view and fetch box result
        $view->template('default', 'breadcrumb', $data, true);

        $string = $view->box();

        // Set breadcrumb at template hooks
        \csphere\core\template\Hooks::breadcrumb($string);

        return true;
    }
}