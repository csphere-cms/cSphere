<?php

/**
 * Contains query string build tools for data manipulation
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
 * Contains query string build tools for data manipulation
 *
 * @category  Core
 * @package   SQL
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class DML
{
    /**
     * Generate sorting parts of queries
     *
     * @param array $sort Sort by column names
     *
     * @return string
     **/

    private static function _sort(array $sort)
    {
        $query = ' ORDER BY ';

        // Check if array dimensions are fine
        if (isset($sort[0]) && !is_array($sort[0])) {

            $sort = [$sort];
        }

        foreach ($sort AS $order) {

            // Sorting order is ASC by default, so just add it for DESC
            if ($order[1] == true) {

                $query .= $order[0] . ' DESC, ';

            } else {

                $query .= $order[0] . ', ';
            }
        }

        $query = substr($query, 0, -2);

        return $query;
    }

    /**
     * Generate join parts of queries
     *
     * @param array $joins Joins to other tables
     *
     * @return string
     **/

    private static function _joins(array $joins)
    {
        $query = '';

        // Check if array dimensions are fine
        if (isset($joins[0]) && !is_array($joins[0])) {

            $joins = [$joins];
        }

        foreach ($joins AS $join) {

            // Empty fourth parameter means its same as third
            // Join 0=table, 1=foreign-table, 2=serial, 3=foreign-id
            if (!isset($join[3]) || $join[3] == '') {

                $join[3] = $join[2];
            }

            $query .= ' INNER JOIN {pre}' . $join[1] . ' ON '
                    . '{pre}' . $join[0] . '.' . $join[2] . ' = '
                    . '{pre}' . $join[1] . '.' . $join[3];
        }

        return $query;
    }

    /**
     * Selects database entries from tables
     *
     * @param string $table      Name of the database table
     * @param mixed  $joins      Joins to other tables as an array
     * @param mixed  $columns    Column names as string or array
     * @param array  $conditions Conditions with column, operation and value
     * @param array  $sort       Sort by column names
     * @param array  $group      Group by column names as string or array
     * @param array  $having     Having clauses with conditions array structure
     *
     * @return array
     **/

    public static function select(
        $table,
        $joins = '',
        $columns = '*',
        array $conditions = [],
        array $sort = [],
        array $group = [],
        array $having = []
    ) {
        $assoc  = [];

        // Add columns to query
        if (is_array($columns)) {

            $columns = implode(', ', $columns);
        }

        // Add joins to query
        if (is_array($joins)) {

            $joins = self::_joins($joins);
        }

        // Build a matching select query
        $query = 'SELECT ' . $columns . ' FROM {pre}' . $table . $joins;

        // Add conditions to query
        if ($conditions != []) {

            $con = \csphere\core\sql\conditions::parse($conditions);

            $query .= ' WHERE ' . $con['query'];
            $assoc  = $con['assoc'];
        }

        // Add group to query
        if ($group != []) {

            $query .= ' GROUP BY ' . implode(', ', $group);
        }

        // Add having to query
        if ($having != []) {

            $hav = \csphere\core\sql\conditions::parse($conditions, true);

            $query .= ' HAVING ' . $hav['query'];
            $assoc  = array_merge($assoc, $hav['assoc']);
        }

        // Add sorting to query
        if ($sort != []) {

            $query .= self::_sort($sort);
        }

        return ['statement' => $query, 'input' => $assoc];
    }

    /**
     * Removes database entries from a table
     *
     * @param string $table      Name of the database table
     * @param array  $conditions Conditions with column, operation and value
     * @param mixed  $joins      Joins to other tables as an array
     *
     * @return array
     **/
    public static function delete($table, array $conditions = [], $joins = '')
    {
        $assoc = [];

        // Add joins to query
        if (is_array($joins)) {

            $joins = self::_joins($joins);
        }

        // Build a matching delete query
        $query = 'DELETE FROM {pre}' . $table . $joins;

        // Add conditions to query
        if ($conditions != []) {

            $con = \csphere\core\sql\conditions::parse($conditions);

            $query .= ' WHERE ' . $con['query'];
            $assoc  = $con['assoc'];
        }

        return ['statement' => $query, 'input' => $assoc];
    }

    /**
     * Inserts new entries into a database table
     *
     * @param string $table Name of the database table
     * @param array  $assoc Array with columns and values
     *
     * @return array
     **/

    public static function insert($table, array $assoc)
    {
        // Build a matching insert query
        $insert = 'INSERT INTO {pre}' . $table . '(';
        $append = ') VALUES (';

        foreach ($assoc AS $key => $value) {

            $insert .= $key . ', ';
            $append .= ':' . $key . ', ';
        }

        // Clear unused var
        unset($value);

        $query = substr($insert, 0, -2) . substr($append, 0, -2) . ')';

        return ['statement' => $query, 'input' => $assoc];
    }

    /**
     * Updates entries inside a database table
     *
     * @param string $table        Name of the database table
     * @param array  $assoc        Array with columns and values
     * @param string $where_column Name of the target database column
     * @param string $where_value  Value of the target database column
     *
     * @return array
     **/

    public static function update($table, array $assoc, $where_column, $where_value)
    {
        // Build a matching update query
        $update = 'UPDATE {pre}' . $table . ' SET ';

        foreach ($assoc AS $key => $value) {

            $update .= $key . ' = :' . $key . ', ';
        }

        // Clear unused var
        unset($value);

        $query = substr($update, 0, -2)
               . ' WHERE ' . $where_column . ' = :where_column';

        $assoc['where_column'] = $where_value;

        return ['statement' => $query, 'input' => $assoc];
    }
}
