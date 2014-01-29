<?php

/**
 * Provides a layer for check / install / uninstall a plugin or theme
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Plugins
 * @author    Micha Schultz <contact@csphere.eu>
 * @copyright 2014 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\market;

/**
 * Provides a layer for checkups to install and uninstall plugins
 *
 * @category  Plugins
 * @package   Plugins
 * @author    Micha Schultz <contact@csphere.eu>
 * @copyright 2014 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Tools
{
    /**
     * Short that will be used
     **/
    private $_short = '';

    /**
     * Type that will be used
     **/
    private $_type = '';

    /**
     * Local path
     **/
    private $_path = '';

    /**
     * Info xml file that will be used
     **/
    private $_file = '';

    /**
     * Remember positive existance checks
     **/
    private $_existance = false;

    /**
     * Array of possible errors
     **/
    private $_error = array();

    /**
     * Get plugin for install / update / delete it
     *
     * @param string $short Name of plugin or theme
     * @param string $type  Type of input data
     *
     * @throws \Exception
     *
     * @return \csphere\core\market\Tools
     **/

    public function __construct($short, $type)
    {

        $this->_path = \csphere\core\init\path();

        $this->_type = $type;

        $this->_short = $short;

        $this->_file = $this->_path . 'csphere/' . $this->_type . 's' . '/' . $this->_short . '/' . $this->_type . '.xml';

        //Check correct type
        if ($this->_type != 'plugin' && $this->_type != 'theme') {

            throw new \Exception('Only plugin oder theme is allowed as type');
        }

        // Check plugin / theme existence
        $this->_existance();
    }

    /**
     * Content of a directory as an array
     *
     * @return boolean
     **/

    private function _existance()
    {
        // Check for xml file
        if (file_exists($this->_file)) {

            $this->_existance = true;
        }
    }

    /**
     * Method to uninstall plugin with pre check
     *
     * @param boolean $action Perform uninstall after pre check, if true
     *
     * @return boolean
     **/

    public function uninstall($action = false)
    {
        if (!$this->_existance) {

            array_push($this->_error, 'Sample Error');

            return false;
        }

        // Check plugin dependencies
        $loader = \csphere\core\service\Locator::get();
        $xml = $loader->load('xml', $this->_type);
        $data = $xml->source($this->_type, $this->_short);

        $vendor = $data['vendor'];

        // Load plugin list
        $meta = new \csphere\core\plugins\Metadata();
        $plugins = $meta->details();

        foreach ($plugins as $plugin) {

            // Load plugin xml infos
            $data = $xml->source('plugin', $plugin['short']);

            $dependencies = $data['environment'][0]['needed'];

            foreach ($dependencies as $dependency) {

                $control_plugin = $vendor . '.' . $this->_short;
                $check_plugin = $dependency['vendor'] . '.' . $dependency['plugin'];

                if ($control_plugin == $check_plugin) {

                    // Dependencies found, no uninstall
                    return false;
                }
            }
        }

        if ($action) {

            //TODO Perform uninstall
        }

        return true;
    }

    /**
     * Checks if plugin oder theme exists
     *
     * @return boolean
     **/

    public function existance()
    {
        return $this->_existance;
    }
}