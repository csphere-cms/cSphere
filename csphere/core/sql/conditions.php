<?php

/**
 * Parses conditions for where and having clauses
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
 * Parses conditions for where and having clauses
 *
 * @category  Core
 * @package   SQL
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Conditions
{
    /**
     * Supported operators for conditions
     **/
    private static $_operators = ['=', '!=', '>', '<', '<>', '>=', '<='];

    /**
     * Generate conditional parts of queries
     *
     * @param array   $conditions Conditions with column, operation and value
     * @param boolean $having     This defines if having or where parts are parsed
     *
     * @return array
     **/

    public static function parse(array $conditions, $having = false)
    {
        $assoc = [];
        $short = ($having === true) ? 'hav' : 'con';
        $query = '';

        // Check if array dimensions are fine
        if (isset($conditions[0]) && !is_array($conditions[0])) {

            $conditions = [$conditions];
        }

        foreach ($conditions AS $num => $con) {

            // Process condition parts
            $sub = self::_parts($short, $num, (array)$con);

            // Append operator and add part to result
            $query .= self::_append($sub['query'], $num, (array)$con);

            $assoc = array_merge($assoc, $sub['assoc']);
        }

        $result = ['query' => $query, 'assoc' => $assoc];

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

    private static function _parts($short, $num, array $con)
    {
        $key   = 0;
        $assoc = [];
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
        $result = ['query' => $query, 'assoc' => $assoc];

        return $result;
    }

    /**
     * Append operators to conditions
     *
     * @param string  $query Query string
     * @param integer $num   Number of condition as an integer
     * @param array   $con   Condition details as an array
     *
     * @return string
     **/

    private static function _append($query, $num, array $con)
    {
        // Prepend with NOT if set
        if (isset($con[3]) && $con[3] == true) {

            $query = 'NOT ' . $query;
        }

        // Prepend with AND or OR if not first
        if ($num != 0) {

            $pre = ' AND ';

            if (isset($con[4]) && $con[4] == true) {

                $pre = ' OR ';
            }

            $query = $pre . $query;
        }

        return $query;
    }
}
