<?php

/**
 * Provides database connectivity for PDO
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
 * Provides database connectivity for PDO
 *
 * @category  Core
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Base_PDO extends \csphere\core\database\Base
{
    /**
     * Stores the database connection
     **/
    protected $con = null;

    /**
     * Returns a formatted array with statistics
     *
     * @return array
     **/

    public function info()
    {
        $info = parent::info();

        $info['client']  = $this->con->getAttribute(\PDO::ATTR_CLIENT_VERSION);
        $info['server']  = $this->con->getAttribute(\PDO::ATTR_SERVER_VERSION);
        $info['version'] = phpversion($info['driver']);

        return $info;
    }

    /**
     * Handle database driver specific transactions
     *
     * @param string $command One of these strings: begin, commit, rollback
     *
     * @return boolean
     **/

    public function transaction($command)
    {
        // Execute requested command
        if ($command == 'commit') {

            $result = $this->con->commit();

        } elseif ($command == 'rollback') {

            $result = $this->con->rollBack();

        } else {

            $result = $this->con->beginTransaction();
        }

        return $result;
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
        // Apply replaces if required
        if (!empty($replace)) {

            $prepare = $this->replace($prepare);
        }

        $statement = $this->_execute($prepare, $assoc);

        // Determine what to return
        if (empty($insertid)) {

            $result = $statement->rowCount();

        } else {

            $result = $this->insertID();
        }

        $this->log($prepare, $assoc, $log);

        return (int)$result;
    }

    /**
     * Returns the ID of the last insert query
     *
     * @return integer
     **/

    protected function insertId()
    {
        return $this->con->lastInsertId();
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
        // Attach limit vars first and max
        if ($first != 0 OR $max != 0) {

            $prepare .= ' ' . $this->limits($first, $max);
        }

        $statement = $this->_execute($prepare, $assoc);

        // Determine what to return
        if ($max == 1) {

            $result = $statement->fetch(\PDO::FETCH_ASSOC);

            if (!is_array($result)) {

                if ($result === false) {

                    $result = array();

                } else {

                    $result = array($result);
                }
            }

        } else {

            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        }

        $this->log($prepare, $assoc, false);

        return (array)$result;
    }

    /**
     * Executes a query
     *
     * @param string $prepare Prepared query string with placeholders
     * @param array  $assoc   Array with columns and values
     *
     * @return \PDOStatement
     **/

    private function _execute($prepare, array $assoc)
    {
        // Rewrite assoc array to use named placeholders
        $data = array();

        foreach ($assoc AS $key => $value) {

            $data[':' . $key] = $value;
        }

        // Prepare and execute the statement
        $prepare = str_replace('{pre}', $this->prefix . '_', $prepare);

        $statement = $this->con->prepare($prepare);

        if (is_object($statement)) {

            $statement->execute($data);

        } else {

            $info = $this->con->errorInfo();

            if (isset($info[2])) {

                $info = $info[2];
            }

            $this->error($prepare, $assoc, $info);
        }

        return $statement;
    }

    /**
     * Builds the query string part for limit and offset
     *
     * @param integer $first Number of the first dataset to show
     * @param integer $max   Number of datasets to show from first on
     *
     * @return string
     **/

    abstract protected function limits($first, $max);

    /**
     * Replaces driver specific query placeholders
     *
     * @param string $replace The string to use for replaces
     *
     * @return string
     **/

    abstract protected function replace($replace);
}