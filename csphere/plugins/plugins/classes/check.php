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
     * @param string $_plugin      Plugin to check possibilty to uninstall
     * @param string $_check       Faster plugin check in some cases
     *
     * @return boolean
     **/

    public static function uninstall($_plugin, $_check = false)
    {
        // Check if plugin is avaible (temporally code maybe better as core component)

        if (!$_check) {

            // Check for plugin XML file
            $path = \csphere\core\init\path();

            $file = $path . 'csphere/plugins/' . $_plugin . '/plugin.xml';

            if (!file_exists($file)) {

                return false;
            }
        }

        // Check plugin dependencies
        $loader = \csphere\core\service\Locator::get();

        $xml = $loader->load('xml', 'plugin');

        $data = $xml->source('plugin', $_plugin);

        $vendor = $data['vendor'];

        $meta = new \csphere\core\plugins\Metadata();

        $plugins = $meta->details();

        foreach ($plugins as $plugin) {

            $xml = $loader->load('xml', 'plugin');

            $data = $xml->source('plugin', $plugin['short']);

            $dependencies = $data['environment'][0]['needed'];

            foreach ($dependencies as $dependency) {

                $control_plugin = $vendor . '.' . $_plugin;

                $check_plugin = $dependency['vendor'] . '.' . $dependency['plugin'];

                if ($control_plugin == $check_plugin) {

                    return false;

                }

            }

        }

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