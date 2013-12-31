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
     * Optional link on plugin name
     **/
    private $_url = '';

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

    public function __construct($plugin, $link = '')
    {
        // Set plugin and plugin url
        $this->_plugin = $plugin;

        if ($link != '') {

            $this->url = \csphere\core\url\Link::params($plugin . '/' . $link);
        }
    }

    /**
     * Adds a new part to the breadcrumb
     *
     * @param string $key  Key name inside plugin specific language file
     * @param string $link Link as slash formated url if it is not /plugin/key
     *
     * @return boolean
     **/

    public function add($key, $link = '')
    {
        // Check if default plugin already translates that action
        $exists = \csphere\core\translation\Fetch::exists('default', $key);
        $target = ($exists == true) ? 'default' : $this->_plugin;

        $lang = \csphere\core\translation\Fetch::key($target, $key);

        if ($link == '') {

            $link = $this->_plugin . '/' . $key;
        }

        $url = \csphere\core\url\Link::params($link);

        $this->_road[] = array('key' => $lang, 'lang' => $lang, 'url' => $url);

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
        $plugin = $this->_plugin;
        $lang   = \csphere\core\translation\Fetch::key($plugin, $plugin);
        $plugin = array('url' => $this->_url, 'lang' => $lang);
        $data   = array('plugin' => $plugin, 'breadcrumb' => $this->_road);

        // Send data to view and fetch box result
        $view->template('default', 'breadcrumb', $data, true);

        $string = $view->box();

        // Set breadcrumb at template hooks
        \csphere\core\template\Hooks::breadcrumb($string);

        return true;
    }
}