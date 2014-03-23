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
     * Stores the logger object
     **/
    protected $logger = null;

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

    public function info()
    {
        $info = $this->config;

        unset($info['password'], $info['timeout']);

        return $info;
    }

    /**
     * Returns a formatted array with all keys and additional information
     *
     * @return array
     **/

    abstract public function keys();

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
        $result = [];

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
        // Get logger if not done yet
        if ($this->logger == null) {

            $this->logger = $this->loader->load('logs');
        }

        $this->logger->log('cache', $key);
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
