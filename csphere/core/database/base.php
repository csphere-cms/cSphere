<?php

/**
 * Provides database connectivity
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
 * Provides database connectivity
 *
 * @category  Core
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Base extends \csphere\core\service\Drivers
{
    /**
     * Stores the logger object
     **/
    protected $logger = null;

    /**
     * Stores the database prefix
     **/
    protected $prefix = '';

    /**
     * Creates the database handler object
     *
     * @param array $config Configuration details as an array
     *
     * @return \csphere\core\database\Base
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        // Set prefix for tables
        $this->prefix = $this->config['prefix'];

        // Set logger object
        $this->logger = $this->loader->load('logs');
    }

    /**
     * Logs database queries
     *
     * @param string  $query The database query for this case
     * @param array   $assoc Array with columns and values
     * @param boolean $log   Defaults to true which enables log files if used
     *
     * @return void
     **/

    protected function log($query, array $assoc, $log = true)
    {
        // Replace assoc data to make queries readable
        if ($assoc != []) {

            foreach ($assoc AS $key => $value) {

                $query = str_replace($key, '\'' . $value . '\'', $query);
            }
        }

        $this->logger->log('database', $query, $log);
    }

    /**
     * Handles errors for the database connection
     *
     * @param string  $query The database query for this case
     * @param array   $assoc Array with columns and values
     * @param string  $msg   The error message if already known
     * @param boolean $more  Append query and and data to message
     *
     * @throws \Exception
     *
     * @return void
     **/

    protected function error($query, array $assoc, $msg = '', $more = true)
    {
        // Check for error message if not provided
        $error = empty($msg) ? 'Unknown' : $msg;

        if ($more === true) {

            // Append query string and data keys
            $error .= "\n" . 'Query: ' . $query . "\n" . 'Data: Array(';

            $data = '';

            foreach ($assoc AS $key => $value) {

                $data .= '\'' . $key . '\', ';
            }

            // Clear unused var
            unset($value);

            $error .= substr($data, 0, -2) . ')';
        }

        // Throw exception
        throw new \Exception($error);
    }

    /**
     * Returns a formatted array with statistics
     *
     * @return array
     **/

    public function info()
    {
        // Build array with information to return
        $info = $this->config;

        unset($info['password'], $info['file']);

        $more = ['version' => '',
                 'client' => '',
                 'server' => '',
                 'size' => '',
                 'encoding' => '',
                 'tables' => ''];

        $info = array_merge($info, $more);

        return $info;
    }

    /**
     * Handle database driver specific transactions
     *
     * @param string $command One of these strings: begin, commit, rollback
     *
     * @return boolean
     **/

    abstract public function transaction($command);

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

    abstract public function exec(
        $prepare, array $assoc, $replace = false, $insertid = false, $log = true
    );

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

    abstract public function query($prepare, array $assoc, $first = 0, $max = 1);
}
