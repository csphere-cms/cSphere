<?php

/**
 * Provides caching functionality as a mock-up
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
 * Provides caching functionality as a mock-up
 *
 * @category  Core
 * @package   Cache
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_None extends Base
{
    /**
     * Keep cache content for current request
     **/
     private $_history = array();

    /**
     * Clears the cache content
     *
     * @return boolean
     **/

    public function clear()
    {
        $this->_history = array();

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
        unset($this->_history[$key], $ttl);

        return true;
    }

    /**
     * Returns a formatted array with statistics
     *
     * @return array
     **/

    public function info()
    {
        $time = time();
        $info = array();

        ksort($this->_history);

        foreach ($this->_history AS $key => $value) {

            $info[] = array('name' => $key, 'time' => $time, 'size' => '');

            unset($value);
        }

        return $info;
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
        $result = isset($this->_history[$key]) ? $this->_history[$key] : false;

        unset($ttl);

        return $result;
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
        $this->log($key);

        $this->_history[$key] = $value;

        unset($ttl);

        return true;
    }
}