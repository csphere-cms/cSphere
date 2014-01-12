<?php

/**
 * Creates the target url for files and downloads
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   URL
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\url;

/**
 * Creates the target url for files and downloads
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   URL
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Load
{
    /**
     * Checks if options are fetched already
     **/
    private static $_init = false;

    /**
     * Stores the dirname part of links
     **/
    private static $_prefix = '';

    /**
     * Fetch options and set flags
     *
     * @return void
     **/

    private static function _init()
    {
        self::$_prefix = \csphere\core\http\Request::get('dirname');
    }

    /**
     * Set details for a plugin image
     *
     * @param string $plugin    Plugin of image file
     * @param string $directory Image subdirectory that cannot be empty
     * @param string $name      Name of image file
     * @param string $extension File extension with "png" as default value
     *
     * @throws \Exception
     *
     * @return string
     **/

    public static function image($plugin, $directory, $name, $extension = 'png')
    {
        // Check and set options if init is not done yet
        if (self::$_init == false) {

            self::_init();
        }

        if (!preg_match("=^[_a-z0-9-]+$=i", $name)) {

            throw new \Exception('Name of plugin image contains unallowed chars');
        }

        $image = self::$_prefix
               . 'csphere/plugins/'
               . $plugin
               . '/images/'
               . $directory
               . '/'
               . $name
               . '.'
               . $extension;

        return $image;
    }
}