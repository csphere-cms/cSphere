<?php

/**
 * Collects the important data from all plugins for a central registry
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Plugins
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\plugins;

/**
 * Collects the important data from all plugins for a central registry
 *
 * @category  Core
 * @package   Plugins
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Metadata extends \csphere\core\xml\Metadata
{
    /**
     * Type of registry
     **/
    protected $driver = 'plugin';

    /**
     * Generate a list of plugins that contain the requested entry
     *
     * @param string $plugin Plugin name
     * @param string $action Action name
     *
     * @return array
    **/

    private function _genEntries($plugin, $action)
    {
        // Get registered plugins from cache
        $reg   = $this->generate();
        $names = [];

        // Create a list of plugins with name, dir and icon per element
        foreach ($reg AS $dir => $info) {

            // Not every plugin might contain entries
            $entries = [];

            if (isset($info['entries']['target'])) {

                $entries = $info['entries']['target'];
            }

            // Search for requested entry within plugin entries
            foreach ($entries AS $entry) {

                if ($plugin == $entry['plugin']
                    && $action == $entry['action']
                ) {
                    // Fetch plugin name from language file
                    $name = \csphere\core\translation\Fetch::key($dir, $dir);

                    $names[$name] = ['name' => $name,
                                     'dir'  => $dir,
                                     'icon' => $info['icon']['value']];
                }
            }
        }

        ksort($names);

        return $names;
    }

    /**
     * Lists all plugin names that contain the requested entry
     *
     * @param string $plugin Plugin name
     * @param string $action Action name
     *
     * @return array
    **/

    public function entries($plugin, $action)
    {
        // Try to load entries from cache
        $key = 'plugins_entries_' . $this->language . '_' . $plugin . '_' . $action;
        $ent = $this->cache->load($key);

        // If cache loading fails load it and create cache file
        if ($ent == false) {

            $ent = $this->_genEntries($plugin, $action);

            $this->cache->save($key, $ent);
        }

        return $ent;
    }

    /**
     * List all entries for startup files
     *
     * @return array
    **/

    public function startup()
    {
        // Create a list for each startup type
        $reg     = $this->generate();
        $startup = ['javascript' => [], 'stylesheet' => []];

        foreach ($reg AS $dir => $plugin) {

            // Check if plugin contains startup files
            if (isset($plugin['startup'])) {

                foreach ($plugin['startup'][0]['file'] AS $file) {

                    // Format array for later usage
                    $type = $file['type'];
                    $top  = ($file['top'] == 'true') ? true : false;

                    $startup[$type][] = ['plugin' => $dir,
                                         'top'    => $top,
                                         'file'   => $file['name']];
                }
            }
        }

        return $startup;
    }

    /**
     * Gets the Type of the current Template
     *
     * @param string $plugin Requested Plugin
     * @param string $action Requested Action
     *
     * @return string
     */

    public function templateType($plugin, $action)
    {
        $reg = $this->generate();

        if (isset($reg[$plugin]['routes'][$action])) {
            $type=$reg[$plugin]['routes'][$action];
        } else {
            $type="frontend";
        }

        return $type;
    }
}
