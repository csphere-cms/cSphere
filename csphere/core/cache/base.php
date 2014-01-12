<?php

/**
 * Provides caching functionality
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Cache
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\cache;

/**
 * Provides caching functionality
 *
 * @category  Core
 * @package   Cache
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Base extends \csphere\core\service\Drivers
{
    /**
     * Clears the cache content
     *
     * @return boolean
     **/

    abstract public function clear();

    /**
     * Removes a cached key
     *
     * @param string $key Name of the key
     * @param int    $ttl Time to life used for the key
     *
     * @return boolean
     **/

    abstract public function delete($key, $ttl = 0);

    /**
     * Returns a formatted array with statistics
     *
     * @return array
     **/

    abstract public function info();

    /**
     * Fetches the desired key
     *
     * @param string $key Name of the key
     * @param int    $ttl Time to life used for the key
     *
     * @return array
     **/

    abstract public function load($key, $ttl = 0);

    /**
     * Fetches the desired keys
     *
     * @param array $keys Name of the keys
     *
     * @return array
     **/

    public function loadArray(array $keys)
    {
        $result = array();

        // Run through all keys
        foreach ($keys AS $key) {

            $result[$key] = $this->load($key);
        }

        return $result;
    }

    /**
     * Logs cache inserts
     *
     * @param string $key The cache key that is stored
     *
     * @return void
     **/

    protected function log($key)
    {
        $this->log = $this->loader->load('logs');

        $this->log->log('cache', $key);
    }

    /**
     * Stores the key with its value in the cache
     *
     * @param string $key   Name of the key
     * @param array  $value Content to be stored
     * @param int    $ttl   Time to life used for the key
     *
     * @return boolean
     **/

    abstract public function save($key, $value, $ttl = 0);
}