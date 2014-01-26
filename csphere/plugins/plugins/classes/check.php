<?php

/**
 * Provides a layer for checkups to install and uninstall plugins
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Plugins
 * @author    Micha Schultz <contact@csphere.eu>
 * @copyright 2014 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\plugins\plugins\classes;

/**
 * Provides a layer for checkups to install and uninstall plugins
 *
 * @category  Plugins
 * @package   Plugins
 * @author    Micha Schultz <contact@csphere.eu>
 * @copyright 2014 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Check
{
    /**
     * Content of a directory as an array
     *
     * @param string $plugin      Plugin to check possibilty to uninstall
     * @param string $short_check Faster plugin check in some cases
     *
     * @return boolean
     **/

    public static function uninstall($plugin, $short_check = false)
    {
        // Check if plugin is avaible (temporally code maybe better as core component)

        if (!$short_check) {

            $path = \csphere\core\init\path();

            $target = $path . 'csphere/plugins/' . $plugin;

            $file = $target . '/' . 'plugin.xml';

            if (!is_dir($target)) {

                return false;
            }

            if (!file_exists($file)) {

                return false;
            }
        }

        //Check plugin dependencies

        return true;
    }

    /**
     * Content of a directory as an array
     *
     * @param string $target Target to plugin xml-file
     *
     * @return boolean
     **/

    public static function install($target)
    {
        return $target;
    }

    /**
     * Content of a directory as an array
     *
     * @param string $plugin Plugin to check possibilty to update it
     *
     * @return boolean
     **/

    public static function update($plugin)
    {
        return $plugin;
    }
}