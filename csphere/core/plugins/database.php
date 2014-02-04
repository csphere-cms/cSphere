<?php

/**
 * Manage database content of a plugin
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
 * Manage database content of a plugin
 *
 * @category  Core
 * @package   Plugins
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Database
{
    /**
     * Plugin name
     **/
    private $_plugin = '';

    /**
     * Database driver object
     **/
    private $_database = null;

    /**
     * Database XML content of plugin
     **/
    private $_structure = array();

    /**
     * Store wether a database XML was found
     **/
    private $_exists = false;

    /**
     * Load plugin database content
     *
     * @param string $plugin Plugin name
     *
     * @return \csphere\core\plugins\Database
     **/

    public function __construct($plugin)
    {
        $this->_plugin = $plugin;

        $loader = \csphere\core\service\Locator::get();

        $this->_database = $loader->load('database');

        // Check for database XML file
        $path = \csphere\core\init\path();
        $file = $path . 'csphere/plugins/' . $this->_plugin . '/database.xml';

        if (file_exists($file)) {

            $this->_exists = true;

            // Get database content of plugin
            $xml = $loader->load('xml', 'database');

            $this->_structure = $xml->source('plugin', $plugin);
        }
    }

    /**
     * Looks for a database XML file inside the plugin
     *
     * @return boolean
     **/

    public function exists()
    {
        return $this->_exists;
    }

    /**
     * List of plugin tables as an array
     *
     * @return array
    **/

    public function tables()
    {
        // Check if plugin contains tables
        $tables = array();

        if (isset($this->_structure['tables'])) {

            foreach ($this->_structure['tables'] AS $table) {

                $tables[] = $table['name'];
            }
        }

        return $tables;
    }

    /**
     * Install plugin database content
     *
     * @param boolean $tables Wether to install tables
     * @param boolean $data   Wether to install data
     *
     * @return boolean
    **/

    public function install($tables, $data)
    {
        // Start with table creation
        if ($tables == true && isset($this->_structure['tables'])) {

            foreach ($this->_structure['tables'] AS $table) {

                $this->_table($table);
            }
        }

        // Go on with data afterwards
        if ($data == true && isset($this->_structure['data'])) {

            $this->_data($this->_structure['data']);
        }

        return true;
    }

    /**
     * Uninstall plugin database tables and options
     *
     * @param boolean $options Clear options table content
     *
     * @throws \Exception
     *
     * @return boolean
    **/

    public function uninstall($options = false)
    {
        // Remove all tables
        if (isset($this->_structure['tables'])) {

            foreach ($this->_structure['tables'] AS $table) {

                // Get table name and check prefix
                $name   = $table['name'];
                $prefix = substr($name, 0, strlen($this->_plugin));

                if ($prefix != $this->_plugin) {

                    throw new \Exception('Table name must begin with plugin name');
                }

                // Remove table itself
                $sql = \csphere\core\sql\DDL::drop($name);

                $this->_database->exec($sql['statement'], $sql['input'], true);
            }
        }

        // Remove all options
        if ($options == true) {

            $sql = \csphere\core\sql\DML::delete(
                'options', 'option_plugin', $this->_plugin
            );

            $this->_database->exec($sql['statement'], $sql['input']);
        }

        return true;
    }

    /**
     * Install plugin database table
     *
     * @param array $table Table structure as an array
     *
     * @throws \Exception
     *
     * @return void
    **/

    private function _table(array $table)
    {
        // Get table name and check prefix
        $name = $table['name'];

        $prefix = substr($name, 0, strlen($this->_plugin));

        if ($prefix != $this->_plugin) {

            throw new \Exception('Table name must begin with plugin name');
        }

        // Create table itself
        $columns  = $table['columns'];
        $primary  = $table['primary'];
        $foreigns = $table['foreigns'];

        $sql = \csphere\core\sql\DDL::create($name, $columns, $primary, $foreigns);

        $this->_database->exec($sql['statement'], $sql['input'], true);

        // Create unique indexes
        foreach ($table['uniques'] AS $unique) {

            $new = $unique['name'];

            $sql = \csphere\core\sql\DDL::index(
                $new, $name, $unique['column'], true
            );

            $this->_database->exec($sql['statement'], $sql['input']);
        }

        // Create all other indexes
        foreach ($table['indexes'] AS $index) {

            $new = $index['name'];

            $sql = \csphere\core\sql\DDL::index($new, $name, $index['column']);

            $this->_database->exec($sql['statement'], $sql['input']);
        }
    }

    /**
     * Install plugin database data
     *
     * @param array $data Data structure as an array
     *
     * @throws \Exception
     *
     * @return void
    **/

    private function _data(array $data)
    {
        $data = $this->_dataCheck($data);

        // Insert queries
        foreach ($data['insert'] AS $insert) {

            $columns = $this->_columns($insert['column']);

            $sql = \csphere\core\sql\DML::insert($insert['table'], $columns);

            $this->_database->exec($sql['statement'], $sql['input']);
        }

        // Update queries
        foreach ($data['update'] AS $update) {

            $columns = $this->_columns($update['column']);

            $where = $update['where'][0]['column'];
            $value = $update['where'][0]['value'];

            $sql = \csphere\core\sql\DML::update(
                $update['table'], $columns, $where, $value
            );

            $this->_database->exec($sql['statement'], $sql['input']);
        }

        // Delete queries
        foreach ($data['delete'] AS $delete) {

            $where = $delete['where'][0]['column'];
            $value = $delete['where'][0]['value'];

            $sql = \csphere\core\sql\DML::delete(
                $delete['table'], $where, $value
            );

            $this->_database->exec($sql['statement'], $sql['input']);
        }
    }

    /**
     * Install plugin database data
     *
     * @param array $data Data structure as an array
     *
     * @return array
    **/

    private function _dataCheck(array $data)
    {
        // Make sure all parts are set
        if (!isset($data['insert'])) {

            $data['insert'] = array();
        }

        if (!isset($data['update'])) {

            $data['insert'] = array();
        }

        if (!isset($data['delete'])) {

            $data['insert'] = array();
        }

        return $data;
    }

    /**
     * Change array structure of columns for queries
     *
     * @param array $columns Columns as an array
     *
     * @return array
    **/

    private function _columns(array $columns)
    {
        $result = array();

        foreach ($columns AS $col) {

            $result[$col['name']] = isset($col['value']) ? $col['value'] : '';
        }

        return $result;
    }
}