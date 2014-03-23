<?php

/**
 * Provides caching functionality for Redis
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
 * Provides caching functionality for Redis
 *
 * @category  Core
 * @package   Cache
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_Redis extends Base
{
    /**
     * Redis object
     **/
    private $_redis = null;

    /**
     * Creates the cache handler object
     *
     * @param array $config Configuration details as an array
     *
     * @throws \Exception
     *
     * @return \csphere\core\cache\Driver_Redis
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        if (!extension_loaded('redis')) {

            throw new \Exception('Extension "redis" not found');
        }

        // Create redis object and connect to server
        $this->_redis = new \Redis();

        $check = $this->_redis->connect(
            $config['host'], (int)$config['port'], (int)$config['timeout']
        );

        if ($check === false) {

            throw new \Exception('Connection to "redis" failed');
        }

        // Authenticate connection if password is given
        if (!empty($config['password'])) {

            $auth = $this->_redis->auth($config['password']);

            if ($auth === false) {

                throw new \Exception('Authentication for "redis" failed');
            }
        }
    }

    /**
     * Clears the cache content
     *
     * @return boolean
     **/

    public function clear()
    {
        $this->_redis->flushDB();

        return true;
    }

    /**
     * Removes a cached key
     *
     * @param string $key Name of the key
     * @param int    $ttl Time to life used for the key
     *
     * @return boolean
     **/

    public function delete($key, $ttl = 0)
    {
        $token = empty($ttl) ? $key : 'ttl_' . $key;

        if ($this->_redis->exists($token)) {

            $this->_redis->delete($token);
        }

        return true;
    }

    /**
     * Returns a formatted array with statistics
     *
     * @return array
     **/

    public function info()
    {
        $info = parent::info();

        $redis_info = $this->_redis->info();

        $info['version'] = phpversion('redis');
        $info['client']  = $info['version'];
        $info['server']  = $redis_info['redis_version'];
        $info['keys']    = $this->_redis->dbSize();

        return $info;
    }

    /**
     * Returns a formatted array with all keys and additional information
     *
     * @return array
     **/

    public function keys()
    {
        $form = [];

        // Time request may not work in all cases
        $time = $this->_redis->time();

        if (is_array($time) && isset($time[0])) {

            $time = $time[0];

        } else {

            $time = (int)$time;
        }

        // Wildcard to get all keys
        $keys = $this->_redis->keys('*');

        foreach ($keys AS $key) {

            // Size hopes that storage uses UTF-8
            $size = $this->_redis->strlen($key);

            $form[$key] = ['name' => $key,
                           'time' => $time,
                           'size' => $size];
        }

        ksort($form);

        return array_values($form);
    }

    /**
     * Fetches the desired key
     *
     * @param string $key Name of the key
     * @param int    $ttl Time to life used for the key
     *
     * @return array
     **/

    public function load($key, $ttl = 0)
    {
        $token = empty($ttl) ? $key : 'ttl_' . $key;

        if ($this->_redis->exists($token)) {

            return unserialize($this->_redis->get($token));
        }

        return false;
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

    public function save($key, $value, $ttl = 0)
    {
        $token = empty($ttl) ? $key : 'ttl_' . $key;

        $this->_redis->set($token, serialize($value));

        if (!empty($ttl)) {

            $this->_redis->setTimeout($token, $ttl);
        }

        $this->log($key);

        return true;
    }
}
