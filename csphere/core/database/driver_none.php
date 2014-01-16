<?php

/**
 * Fallback for database startup errors
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\database;

/**
 * Fallback for database startup errors
 *
 * @category  Core
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_None extends Base
{
    /**
     * Establishes the connection with the database
     *
     * @return void
     **/

    protected function connect()
    {
        $this->con = new \csphere\core\database\Mockup();
    }

    /**
     * Builds the query string part for limit and offset
     *
     * @param integer $first Number of the first dataset to show
     * @param integer $max   Number of datasets to show from first on
     *
     * @return string
     **/

    protected function limits($first, $max)
    {
        $string = 'LIMIT ' . (int)$max . ' OFFSET ' . (int)$first;

        return $string;
    }

    /**
     * Replaces driver specific query placeholders
     *
     * @param string $replace The string to use for replaces
     *
     * @return string
     **/

    protected function replace($replace)
    {
        $change_none = array('{engine}' => '',
                             '{integer}' => 'integer',
                             '{optimize}' => 'OPTIMIZE',
                             '{serial}' => 'serial',
                             '{text}' => 'text',
                             '{varchar}' => 'varchar'
        );

        foreach ($change_none AS $key => $none) {

            $replace = str_replace($key, $none, $replace);
        }

        return $replace;
    }

    /**
     * Handles errors for the database connection
     *
     * @param string  $query The database query for this case
     * @param array   $assoc Array with columns and values
     * @param string  $msg   The error message if already known
     * @param boolean $more  Append query and and data to message
     *
     * @return void
     **/

    protected function error($query, array $assoc, $msg = '', $more = true)
    {
        unset($query, $assoc, $msg, $more);
    }
}