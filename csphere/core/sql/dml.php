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
     * Supported operators for conditions
     **/
    private static $_operators = array('=', '!=', '>', '<', '<>', '>=', '<=');

    /**
     * Generate conditional parts of queries
     *
     * @param array  $conditions Conditions with column, operation and value
     * @param string $short      Shorthandle for assoc array keys, e.g. con
     *
     * @return array
     **/

    private static function _conditions($conditions, $short)
    {
        $assoc = array();

        $query = '';

        // Check if array dimensions are fine
        if (isset($conditions[0]) AND !is_array($conditions[0])) {

            $conditions = array($conditions);
        }

        foreach ($conditions AS $num => $con) {

            // Process condition parts
            $sub = self::_conPart($short, $num, $con);

            // Prepend with NOT if set
            if (isset($con[3]) AND $con[3] == true) {

                $sub['query'] = 'NOT ' . $sub['query'];
            }

            // Prepend with AND or OR if not first
            if ($num != 0) {

                $pre = ' AND ';

                if (isset($con[4]) AND $con[4] == true) {

                    $pre = ' OR ';
                }

                $sub['query'] = $pre . $sub['query'];
            }

            $query .= $sub['query'];

            $assoc = array_merge($assoc, $sub['assoc']);
        }

        $result = array('query' => $query, 'assoc' => $assoc);

        return $result;
    }

    /**
     * Generate part of a single condition
     *
     * @param string  $short Shorthandle for assoc array keys, e.g. con
     * @param integer $num   Number of condition as an integer
     * @param array   $con   Condition details as an array
     *
     * @return array
     **/

    private static function _conPart($short, $num, array $con)
    {
        $key = 0;

        $assoc = array();

        $query = '';

        // Bind must be unique per query condition
        $bind = $short . $num;

        // Append simple oerator checks
        if (in_array($con[1], self::$_operators)) {

            $query .= $con[0] . ' ' . $con[1] . ' :' . $bind;

            $assoc[$bind] = $con[2];

        } elseif ($con[1] == 'like') {

            // Append like comparisons
            $query .= $con[0] . ' LIKE :' . $bind;

            $assoc[$bind] = $con[2];

        } elseif ($con[1] == 'between') {

            // Append between checks
            $query .= $con[0] . ' BETWEEN :' . $bind
                    . 'b1 AND :' . $bind . 'b2';

            $assoc[$bind . 'b1'] = $con[2][0];
            $assoc[$bind . 'b2'] = $con[2][1];

        } elseif ($con[1] == 'in') {

            // Append in array checks
            $query .= $con[0] . ' IN (';

            foreach ($con[2] AS $val) {

                $query .= ':' . $bind . 'i' . $key . ', ';

                $assoc[$bind . 'i' . $key] = $val;

                $key++;
            }

            $query = substr($query, 0, -2) . ')';
        }

        // Create result array
        $result = array('query' => $query, 'assoc' => $assoc);

        return $result;
    }

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
        if (isset($sort[0]) AND !is_array($sort[0])) {

            $sort = array($sort);
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
        if (isset($joins[0]) AND !is_array($joins[0])) {

            $joins = array($joins);
        }

        foreach ($joins AS $join) {

            // Empty fourth parameter means its same as third
            // Join 0=table, 1=foreign-table, 2=serial, 3=foreign-id
            if (!isset($join[3]) OR $join[3] == '') {

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
        array $conditions = array(),
        array $sort = array(),
        array $group = array(),
        array $having = array()
    ) {
        $assoc  = array();

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
        if ($conditions != array()) {

            $con = self::_conditions($conditions, 'con');

            $query .= ' WHERE ' . $con['query'];
            $assoc  = $con['assoc'];
        }

        // Add group to query
        if ($group != array()) {

            $query .= ' GROUP BY ' . implode(', ', $group);
        }

        // Add having to query
        if ($having != array()) {

            $hav = self::_conditions($conditions, 'hav');

            $query .= ' HAVING ' . $hav['query'];
            $assoc  = array_merge($assoc, $hav['assoc']);
        }

        // Add sorting to query
        if ($sort != array()) {

            $query .= self::_sort($sort);
        }

        return array('statement' => $query, 'input' => $assoc);
    }

    /**
     * Removes database entries from a table
     *
     * @param string $table        Name of the database table
     * @param string $where_column Name of the target database column
     * @param string $where_value  Value of the target database column
     *
     * @return array
     **/

    public static function delete($table, $where_column, $where_value)
    {
        // Build a matching delete query
        $query = 'DELETE FROM {pre}' . $table
               . ' WHERE ' . $where_column . ' = :where_column';

        $assoc = array('where_column' => $where_value);

        return array('statement' => $query, 'input' => $assoc);
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

        return array('statement' => $query, 'input' => $assoc);
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

        return array('statement' => $query, 'input' => $assoc);
    }
}