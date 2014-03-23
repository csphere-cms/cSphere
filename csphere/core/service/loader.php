<?php

/**
 * Creates objects of a specified type using the configuration
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Service
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\service;

/**
 * Creates objects of a specified type using the configuration
 *
 * @category  Core
 * @package   Service
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Loader
{
    /**
     * Array with config variables that is fetched later on
     **/
    private $_config = [];

    /**
     * Array with drivers that have already been configured
     **/
    private $_driver = [];

    /**
     * Determines if fallbacks are tried on problems
     **/
    private $_rescue = true;

    /**
     * Get configuration
     *
     * @param array $config Array with config flags to store
     *
     * @return \csphere\core\service\Loader
     **/

    public function __construct(array $config)
    {
        // Get content of config array and store it
        $this->_config = $config;
    }

    /**
     * Sets if a fallback should be tried on any driver problems
     *
     * @param boolean $fallback Fallback that defaults to true
     *
     * @return boolean
     **/

    public function rescue($fallback = true)
    {
        $this->_rescue = $fallback;

        return true;
    }

    /**
     * Service provider for core components
     *
     * @param string  $component Name of the core component with driver support
     * @param string  $driver    Driver name without any prefixes
     * @param array   $config    Configuration options for the driver
     * @param boolean $default   Set new driver as default for component
     *
     * @return object
     **/

    public function load(
        $component, $driver = '', array $config = [], $default = false
    ) {
        // Determine configuration details
        $config = $this->_merge($component, $driver, $config);

        // If it is unclear which object to use create it
        $key = $component . '_driver_' . $config['driver'];

        if (empty($this->_driver[$key])) {

            $this->_driver[$key] = $this->_container($component, $config);
        }

        // Store config of new default
        if ($default === true) {

            $this->_config[$component] = $config;
        }

        return $this->_driver[$key];
    }

    /**
     * Handles object creation errors by creating a log entry
     *
     * @param string     $component Name of the core component with driver support
     * @param string     $driver    Driver name without any prefixes
     * @param \Exception $exception Exception that occured and got catched
     *
     * @return string
     **/

    private function _error($component, $driver, \Exception $exception)
    {
        $msg = 'Message: Service Container failed to load component "'
             . $component . '" with driver "' . $driver . '"' . "\n"
             . 'Exception: ' . $exception->getMessage() . "\n"
             . 'Code: ' . $exception->getCode() . "\n"
             . 'File: ' . $exception->getFile() . "\n"
             . 'Line: ' . $exception->getLine();

        return $msg;
    }

    /**
     * Tries to create the requested component driver
     *
     * @param string $component Name of the core component with driver support
     * @param array  $config    Configuration options for the driver
     *
     * @return object
     **/

    private function _container($component, array $config)
    {
        // Check for empty driver
        if ($config['driver'] == '') {

            $config['driver'] = 'none';
        }

        // Create the destination object and return it
        $class = '\csphere\core\\' . $component . '\\driver_' . $config['driver'];

        try {
            $object = new $class($config);

        } catch (\Exception $driver_error) {

            // Try a fallback
            $object = $this->_fallback($component, $config, $driver_error);
        }

        return $object;
    }

    /**
     * Try to load something without fallbacks
     *
     * @param string     $component Name of the core component with driver support
     * @param array      $config    Configuration options for the driver
     * @param \Exception $exception Exception that occured
     *
     * @throws \Exception
     *
     * @return \csphere\core\service\Loader
     **/

    private function _fallback($component, array $config, $exception)
    {
        // Try to use a fallback to keep the process alive
        if ($config['driver'] != 'none' && $this->_rescue === true) {

            $old_driver       = $config['driver'];
            $config['driver'] = 'none';

            $object = $this->_container($component, $config);

            // Log the error
            $log = ($component == 'logs') ? $object : $this->load('logs');

            $msg = $this->_error($component, $old_driver, $exception);

            $log->log('errors', $msg);

            return $object;

        } else {

            // Rethrow exception otherwise
            throw $exception;
        }
    }

    /**
     * Handle config content of components
     *
     * @param string $component Name of the core component with driver support
     * @param string $driver    Driver name without any prefixes
     * @param array  $config    Configuration options for the driver
     *
     * @return array
     **/

    private function _merge($component, $driver, array $config)
    {
        // Check for configuration on empty name
        if (empty($driver)) {

            $driver = 'none';

            if (isset($this->_config[$component]['driver'])) {

                // Get driver from initial configuration
                $driver = $this->_config[$component]['driver'];

                $config = array_merge($this->_config[$component], $config);
            }
        }

        // Driver should be part of config array
        $config['driver'] = $driver;

        return $config;
    }
}
