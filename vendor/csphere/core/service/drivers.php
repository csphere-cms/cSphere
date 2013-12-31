<?php

/**
 * Pattern for basic functionality of drivers
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
 * Pattern for basic functionality of drivers
 *
 * @category  Core
 * @package   Service
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Drivers
{
    /**
     * Stores the loader object
     **/
    protected $loader = null;

    /**
     * Stores the driver configuration
     **/
    protected $config = array();

    /**
     * Creates the driver handler object
     *
     * @param array $config Configuration details as an array
     *
     * @return \csphere\core\service\Drivers
     **/

    public function __construct(array $config)
    {
        // Store loader object
        $this->loader = \csphere\core\service\Locator::get();

        // Check for empty driver
        if (empty($config['driver'])) {

            $config['driver'] = 'none';
        }

        $this->config = $config;
    }

    /**
     * Returns the name of the driver
     *
     * @return string
     **/

    public function driver()
    {
        return $this->config['driver'];
    }
}