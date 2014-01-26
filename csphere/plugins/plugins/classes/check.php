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
     * @param string  $plugin Plugin to check possibilty to uninstall
     *
     * @return boolean
     **/

    public static function uninstall($plugin, $short_check = false)
    {        
        // Check if plugin is avaible
        $path = "\csphere\plugins".$plugin;
        
        $target = $path."\plugin.xml";
        
        if(!$short_check)
        {
            if(!is_dir($path) OR !file_exists($target))
            {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Content of a directory as an array
     *
     * @param string  $target Target to plugin xml-file
     *
     * @return boolean
     **/

    public static function install($target)
    {
        return true;
    }
}