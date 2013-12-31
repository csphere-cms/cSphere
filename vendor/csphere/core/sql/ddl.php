<?php

/**
 * Contains query string build tools for data definition
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   SQL
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\sql;

/**
 * Contains query string build tools for data definition
 *
 * @category  Core
 * @package   SQL
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class DDL
{
    /**
     * Creates a new database table
     *
     * @param string $table    Name of the database table
     * @param array  $columns  Names of the database columns
     * @param array  $primary  Columns to use for the primary key
     * @param array  $foreigns Foreign keys to apply to the table
     *
     * @throws \Exception
     *
     * @return array
     **/

    public static function create(
        $table, array $columns, array $primary, array $foreigns = array()
    ) {
        // Build a matching create query
        $query = 'CREATE TABLE {pre}' . $table . ' (';

        // Add columns
        $query .= self::_createColumns($columns);

        // Add primary key
        $query .= 'PRIMARY KEY (';

        foreach ($primary AS $column) {

            $query .= $column['name'] . ', ';
        }

        $query = substr($query, 0, -2) . ')';

        // Add foreign keys
        if ($foreigns != array()) {

            $query .= ', ' . self::_createForeigns($foreigns);
        }

        $query .= '){engine}';

        return array('statement' => $query, 'input' => array());
    }

    /**
     * Creates the column parts for table creation
     *
     * @param array $columns Array with columns
     *
     * @throws \Exception
     *
     * @return string
     **/

    private static function _createColumns(array $columns)
    {
        $serial = 0;
        $query  = '';

        foreach ($columns AS $column) {

            // Some column types may have a limit in length
            $max  = '';
            $type = $column['datatype'];

            if ($type == 'serial') {

                $serial++;
            }

            if (!empty($column['max'])
                AND ($type == 'integer' OR $type == 'varchar')
            ) {

                $max = '(' . (int)$column['max'] . ')';
            }

            // Some columns might provide a default value
            $default = ' NOT NULL';

            if (isset($column['default']) AND $column['default'] != '') {

                $default .= ' DEFAULT \'' . $column['default'] . '\'';
            }

            $query .= $column['name']
                    . ' {' . $type . '}'
                    . $max . $default . ', ';
        }

        // Every table needs exactly one serial
        if ($serial != 1) {

            $msg = 'Need exactly one serial column, but found: ' . $serial;

            throw new \Exception($msg);
        }

        return $query;
    }

    /**
     * Creates the foreign key parts for table creation
     *
     * @param array $foreigns Array with foreign keys
     *
     * @return string
     **/

    private static function _createForeigns(array $foreigns)
    {

        $query = '';

        foreach ($foreigns AS $foreign) {

            $ref = $foreign['table'];
            $names = '';
            $targets = '';

            $query .= 'FOREIGN KEY (';

            // Add column name and its target per element
            foreach ($foreign['column'] AS $column) {

                $names .= $column['name'] . ', ';
                $targets .= $column['target'] . ', ';
            }

            $query .= substr($names, 0, -2) . ') REFERENCES {pre}' . $ref;
            $query .= ' (' . substr($targets, 0, -2) . '), ';
        }

        $query = substr($query, 0, -2);

        return $query;
    }

    /**
     * Drops a database table
     *
     * @param string  $table     Name of the database table
     * @param boolean $if_exists Defaults to true while ignoring not found errors
     *
     * @return array
     **/

    public static function drop($table, $if_exists = true)
    {
        // Build a matching drop query
        $query = 'DROP TABLE ';

        $query .= empty($if_exists) ? '' : 'IF EXISTS ';

        $query .= '{pre}' . $table;

        return array('statement' => $query, 'input' => array());
    }

    /**
     * Creates a new index
     *
     * @param string  $name    Name for the index to create
     * @param string  $table   Name of the database table
     * @param array   $columns Columns to use for the index
     * @param boolean $unique  Enforces combined column data to be unique
     *
     * @return array
     **/

    public static function index($name, $table, array $columns, $unique = false)
    {
        // Build a matching index query
        $query = empty($unique) ? 'CREATE INDEX ' : 'CREATE UNIQUE INDEX ';

        $query .= $name . ' ON {pre}' . $table . ' (';

        foreach ($columns AS $key) {

            // Column array can be build up with a name tag
            if (isset($key['name'])) {

                $key = $key['name'];
            }

            $query .= $key . ', ';
        }

        $query = substr($query, 0, -2) . ')';

        return array('statement' => $query, 'input' => array());
    }

    /**
     * Optimizes database tables
     *
     * @param array $tables Names of the database tables
     *
     * @return array
     **/

    public static function optimize(array $tables)
    {
        // Build a matching optimize query
        $query = '';

        foreach ($tables AS $table) {

            $query .= '{optimize} {pre}' . $table . ';' . "\n";
        }

        return array('statement' => $query, 'input' => array());
    }
}