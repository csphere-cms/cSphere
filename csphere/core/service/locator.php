<?php

/**
 * Holds a class loader instance
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
 * Holds a class loader instance
 *
 * @category  Core
 * @package   Service
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Locator
{
    /**
     * Store loader object
     **/

    private static $_loader = null;

    /**
     * Creates the instance of the class loader
     *
     * @param array $config Array with config flags to store
     *
     * @return object
     **/

    public static function start(array $config)
    {
        self::$_loader = new \csphere\core\service\Loader($config);
    }

    /**
     * Provides the class loader object
     *
     * @return \csphere\core\service\Loader
     **/

    public static function get()
    {
        return self::$_loader;
    }
}
