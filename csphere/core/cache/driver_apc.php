<?php

/**
 * Provides caching functionality for APC and APCu
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
 * Provides caching functionality for APC and APCu
 *
 * @category  Core
 * @package   Cache
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_APC extends Base
{
    /**
     * Creates the cache handler object
     *
     * @param array $config Configuration details as an array
     *
     * @throws \Exception
     *
     * @return \csphere\core\cache\Driver_APC
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        if (!function_exists('apc_exists')) {

            throw new \Exception('Extension "apc" outdated or not found');
        }
    }

    /**
     * Clears the cache content
     *
     * @return boolean
     **/

    public function clear()
    {
        // Workaround for APCu version below 4.0.2
        $reflection = new \ReflectionFunction('apc_clear_cache');
        $parameters = $reflection->getParameters();

        if ($parameters[0]->getName() == 'info') {

            apc_clear_cache();

        } else {

            apc_clear_cache('user');
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

        if (apc_exists($token)) {

            apc_delete($token);
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

        $stats = apc_cache_info('user');
        $keys  = isset($stats['nentries']) ? $stats['nentries'] : '';

        if (empty($keys) AND isset ($stats['cache_list'])) {

            $keys = count($stats['cache_list']);
        }

        $info['version'] = phpversion('apc');
        $info['client']  = '';
        $info['server']  = '';
        $info['keys']    = $keys;

        // Check for apcu
        if (extension_loaded('apcu')) {

            $info['client'] = 'apcu ' . phpversion('apcu');
        }

        return $info;
    }

    /**
     * Returns a formatted array with all keys and additional information
     *
     * @return array
     **/

    public function keys()
    {
        $form = array();

        $info = apc_cache_info('user');
        $list = isset($info['cache_list']) ? $info['cache_list'] : array();

        foreach ($list AS $num => $data) {

            $handle = $data['info'] . ' (' . $num . ')';

            $form[$handle] = array('name' => $handle, 'time' => $data['mtime'],
                                   'size' => $data['mem_size']);
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

        if (apc_exists($token)) {

            return apc_fetch($token);
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

        apc_store($token, $value, $ttl);

        $this->log($key);

        return true;
    }
}