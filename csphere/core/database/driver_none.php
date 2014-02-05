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
     * Handle database driver specific transactions
     *
     * @param string $command One of these strings: begin, commit, rollback
     *
     * @return boolean
     **/

    public function transaction($command)
    {
        unset($command);

        return false;
    }

    /**
     * Sends a command to the database and gets the affected rows
     *
     * @param string  $prepare  Prepared query string with placeholders
     * @param array   $assoc    Array with columns and values
     * @param boolean $replace  If more than {pre} needs to be replaced
     * @param boolean $insertid Return the last insert id instead of a rowcount
     * @param boolean $log      Defaults to true which enables log files if used
     *
     * @return integer
     **/

    public function exec(
        $prepare, array $assoc, $replace = false, $insertid = false, $log = true
    ) {
        unset($prepare, $assoc, $replace, $insertid, $log);

        return 0;
    }

    /**
     * Sends a query to the database and fetches the result
     *
     * @param string  $prepare Prepared query string with placeholders
     * @param array   $assoc   Array with columns and values
     * @param integer $first   Number of the first dataset to show
     * @param integer $max     Number of datasets to show from first on
     *
     * @return array
     **/

    public function query($prepare, array $assoc, $first = 0, $max = 1)
    {
        unset($prepare, $assoc, $first, $max);

        return [];
    }
}