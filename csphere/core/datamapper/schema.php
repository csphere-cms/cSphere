<?php

/**
 * Format and cache database xml details for usage
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Datamapper
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\datamapper;

/**
 * Format and cache database xml details for usage
 *
 * @category  Core
 * @package   Datamapper
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Schema
{
    /**
     * Service loader object
     **/
    private static $_loader = null;

    /**
     * XML driver object
     **/
    private static $_xml = null;

    /**
     * Cache driver object
     **/
    private static $_cache = null;

     /**
     * Store database files that are already opened
     **/
    private static $_loaded = array();

    /**
     * Load schema for database table
     *
     * @param string $plugin Plugin name
     * @param string $table  Table name without plugin_ prefix
     *
     * @throws \Exception
     *
     * @return array
     **/

    public static function load($plugin, $table = '')
    {
        // Empty table means that it is named like the plugin
        $schema = $plugin;

        if ($table != '') {

            $schema .= '_' . $table;
        }

        // Check if database structure is already loaded
        if (!isset(self::$_loaded[$plugin])) {

            self::$_loaded[$plugin] = self::_cache($plugin);
        }

        // Return info array if it exists
        if (isset(self::$_loaded[$plugin][$schema])) {

            return self::$_loaded[$plugin][$schema];

        } else {

            // Full table name (schema) should lead to less confusion
            $msg = 'Plugin "' . $plugin . '" lacks a database table:' . $schema;

            throw new \Exception($msg);
        }
    }

    /**
     * Sets options to work with database files
     *
     * @return void
     **/

    private static function _settings()
    {
        self::$_loader = \csphere\core\service\Locator::get();

        self::$_cache = self::$_loader->load('cache');
    }

    /**
     * Delivers the requested database file
     *
     * @param string $plugin Plugin of database file
     *
     * @return array
     **/

    private static function _cache($plugin)
    {
        // Load cache and settings if not done yet
        if (self::$_cache == null) {

            self::_settings();
        }

        $token = 'dm_schema_' . $plugin;

        // Look for plugin inside cache
        $schema = self::$_cache->load($token);

        // If cache loading fails load it and create cache file
        if ($schema == false) {

            $schema = self::_open($plugin);

            self::$_cache->save($token, $schema);
        }

        return $schema;
    }

    /**
     * Gets the content for the requested database file
     *
     * @param string $plugin Plugin of database file
     *
     * @return array
     **/

    private static function _open($plugin)
    {
        // Set XML loader if not done yet
        if (self::$_xml == null) {

            self::$_xml = self::$_loader->load('xml', 'database');
        }

        // Get data array of XML file
        $data = self::$_xml->source('plugin', $plugin);

        // Convert table data for later usage
        $schema = array();

        foreach ($data['tables'] AS $table) {

            // Mark serial column name of table
            $serial = '';

            foreach ($table['columns'] AS $column) {

                if ($column['datatype'] == 'serial') {

                    $serial = $column['name'];
                }
            }

            // Build schema array for caching
            $add = array('serial' => $serial);

            $schema[$table['name']] = array_merge($table, $add);
        }

        return $schema;
    }
}