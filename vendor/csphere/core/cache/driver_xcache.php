<?php

/**
 * Provides caching functionality on the filesystem
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
 * Provides caching functionality on the filesystem
 *
 * @category  Core
 * @package   Cache
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_Xcache extends Base
{
    /**
     * Creates the cache handler object
     *
     * @param array $config Configuration details as an array
     *
     * @throws \Exception
     *
     * @return \csphere\core\cache\Driver_XCache
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        if (!extension_loaded('xcache')) {

            throw new \Exception('Extension "xcache" not found');
        }
    }

    /**
     * Clears the cache content
     *
     * @return boolean
     **/

    public function clear()
    {
        $cache_count = xcache_count(XC_TYPE_VAR);

        for ($i = 0; $i < $cache_count; $i++) {

            xcache_clear_cache(XC_TYPE_VAR, $i);
        }

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

        if (xcache_isset($token)) {

            xcache_unset($token);
        }
    }

    /**
     * Returns a formatted array with statistics
     *
     * @return array
     **/

    public function info()
    {
        $form = array();

        $cache_count = xcache_count(XC_TYPE_VAR);

        for ($i = 0; $i < $cache_count; $i++) {

            $info = xcache_list(XC_TYPE_VAR, $i);

            foreach ($info['cache_list'] AS $num => $data) {

                $handle = $data['name'] . ' (' . $i . '.' . $num . ')';

                $form[$handle] = array('name' => $handle, 'time' => $data['ctime'],
                                       'size' => $data['size']);
            }
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

        if (xcache_isset($token)) {

            return xcache_get($token);
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

        xcache_set($token, $value, $ttl);

        $this->log($key);

        return true;
    }
}