<?php

/**
 * Provides caching functionality for WinCache
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
 * Provides caching functionality for WinCache
 *
 * @category  Core
 * @package   Cache
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_Wincache extends Base
{
    /**
     * Creates the cache handler object
     *
     * @param array $config Configuration details as an array
     *
     * @throws \Exception
     *
     * @return \csphere\core\cache\Driver_WinCache
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        if (!extension_loaded('wincache')) {

            throw new \Exception('Extension "wincache" not found');
        }
    }

    /**
     * Clears the cache content
     *
     * @return boolean
     **/

    public function clear()
    {
        wincache_ucache_clear();

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

        if (wincache_ucache_exists($token)) {

            wincache_ucache_delete($token);
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

        $stats = wincache_ucache_info();

        $info['version'] = phpversion('wincache');
        $info['client']  = '';
        $info['server']  = '';
        $info['keys']    = $stats['total_item_count'];

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

        $info = wincache_ucache_info();

        foreach ($info['ucache_entries'] AS $num => $data) {

            $handle = $data['key_name'] . ' (' . $num . ')';

            $age = time() - $data['age_seconds'];

            $form[$handle] = ['name' => $handle, 'time' => $age,
                              'size' => $data['value_size']];
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

        if (wincache_ucache_exists($token)) {

            return wincache_ucache_get($token);
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

        wincache_ucache_set($token, $value, $ttl);

        $this->log($key);

        return true;
    }
}