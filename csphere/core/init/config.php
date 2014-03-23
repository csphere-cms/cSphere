<?php

/**
 * Holds the configuration details
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Init
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\init;

/**
 * Holds the configuration details
 *
 * @category  Core
 * @package   Init
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Config
{
    /**
     * Array with config settings
     **/
    private $_config = [];

    /**
     * Error details as an array
     **/
    private $_error = [];

    /**
     * Prepare configuration
     *
     * @return \csphere\core\init\Config
     **/

    public function __construct()
    {
        // Try to load config file
        $this->_configFile();
    }

    /**
     * Loads the configuration file
     *
     * @return void
     **/

    private function _configFile()
    {
        $config = [];

        // Try to load the config file
        $file = \csphere\core\init\path() . 'csphere/config/config.php';

        if (file_exists($file)) {

            include $file;

        } else {

            $this->_error = ['error' => 'config_missing', 'file' => $file];
        }

        // Check for config array to be correct
        if (!isset($config) || !is_array($config)) {

            $this->_error = ['error' => 'config_corrupt', 'file' => $file];
        }

        $this->_config = $config;
    }

    /**
     * Pass configuration details
     *
     * @return array
     **/

    public function get()
    {
        return $this->_config;
    }

    /**
     * Pass error details
     *
     * @return array
     **/

    public function error()
    {
        return $this->_error;
    }
}
