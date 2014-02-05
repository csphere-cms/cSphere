<?php

/**
 * Provides a layer for persistency
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
 * Provides a layer for persistency
 *
 * @category  Core
 * @package   Datamapper
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Base
{
    /**
     * Database service object
     **/
    protected $database = null;

    /**
     * Name of target plugin
     **/
    protected $plugin;

    /**
     * Name of plugin table
     **/
    protected $table;

    /**
     * Name of ID column in that table
     **/
    protected $serial;

    /**
     * Combination of plugin and table that is generated automatically
     **/
    protected $schema;

    /**
     * Construction details of schema
     **/
    protected $structure;

    /**
     * Construction details of schema
     **/
    protected $joins = [];

    /**
     * Prepare values that are needed for later usage
     *
     * @param string $plugin Plugin name
     * @param string $table  Table name without plugin_ prefix
     *
     * @return \csphere\core\datamapper\Base
     **/

    public function __construct($plugin, $table = '')
    {
        // Get database service object
        $loader = \csphere\core\service\Locator::get();

        $this->database = $loader->load('database');

        // Set plugin, table and schema to work with
        $this->plugin = $plugin;
        $this->table  = $table;

        $this->schema = $plugin;

        if ($this->table != '') {

            $this->schema .= '_' . $this->table;
        }

        // Load schema details, e.g. for creating new entries
        $this->structure = \csphere\core\datamapper\Schema::load(
            $this->plugin, $this->table
        );

        $this->serial = $this->structure['serial'];
    }

    /**
     * Name of serial column in this table
     *
     * @return string
     **/

    public function serial()
    {
        return $this->serial;
    }
}