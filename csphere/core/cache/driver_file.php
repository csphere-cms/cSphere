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

class Driver_File extends Base
{
    /**
     * Stores the cache directory
     **/
    private $_dir = '';

    /**
     * Files to exclude for stats
     **/
    private $_exclude = array('info.txt');

    /**
     * Creates the cache handler object
     *
     * @param array $config Configuration details as an array
     *
     * @throws \Exception
     *
     * @return \csphere\core\cache\Driver_File
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->_dir = \csphere\core\init\path() . 'csphere/storage/cache/';

        if (!is_writeable($this->_dir)) {

            throw new \Exception('Directory "' . $this->_dir . '" is not writeable');
        }
    }

    /**
     * Clears the cache content
     *
     * @return boolean
     **/
    public function clear()
    {
        $content = \csphere\core\files\File::search(
            $this->_dir, false, $this->_exclude
        );

        foreach ($content AS $file) {

            unlink($this->_dir . $file);
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

        if (file_exists($this->_dir . $token . '.tmp')) {

            unlink($this->_dir . $token . '.tmp');
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

        $files = \csphere\core\files\File::search(
            $this->_dir, false, $this->_exclude
        );

        $info['version'] = '';
        $info['client']  = '';
        $info['server']  = '';
        $info['keys']    = count($files);

        return $info;
    }

    /**
     * Returns a formatted array with all keys and additional information
     *
     * @return array
     **/

    public function keys()
    {
        $info = \csphere\core\files\File::search(
            $this->_dir, false, $this->_exclude
        );

        $form = array();

        foreach ($info AS $filename) {

            $form[$filename] = array('name' => $filename,
                'time' => filemtime($this->_dir . $filename),
                'size' => filesize($this->_dir . $filename));
        }

        $form = array_values($form);

        return $form;
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

        if (file_exists($this->_dir . $token . '.tmp')) {

            if (empty($ttl)
                OR filemtime($this->_dir . $token . '.tmp') >= (time() - $ttl)
            ) {

                $string = file_get_contents($this->_dir . $token . '.tmp');

                return unserialize($string);
            }
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

        $store = serialize($value);

        $save_cache = fopen($this->_dir . $token . '.tmp', 'w');

        // Set stream encoding if possible to avoid converting issues
        if (function_exists('stream_encoding')) {

            stream_encoding($save_cache, 'UTF-8');
        }

        fwrite($save_cache, $store);
        fclose($save_cache);

        chmod($this->_dir . $token . '.tmp', 0755);

        $this->log($key);

        return true;
    }
}