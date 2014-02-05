<?php

/**
 * Adds support for PostgreSQL databases
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
 * Adds support for PostgreSQL databases
 *
 * @category  Core
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_PDO_PGSQL extends Base_PDO
{
    /**
     * Creates the database handler object
     *
     * @param array $config Configuration details as an array
     *
     * @throws \Exception
     *
     * @return \csphere\core\database\Driver_PDO_PGSQL
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        if (!extension_loaded('pdo_pgsql')) {

            throw new \Exception('Extension "pdo_pgsql" not found');
        }

        $dsn = empty($config['host']) ? '' :
               'host=' . $config['host'] . ';';

        $dsn .= 'dbname=' . $config['schema'];

        $options = [];

        // Use try catch to hide connection details
        try {

            $this->con = new \PDO(
                'pgsql:' . $dsn, $config['username'], $config['password'], $options
            );

            $this->con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $this->con->exec('SET client_encoding TO UNICODE');
        }
        catch(\PDOException $pdo_error) {

            $this->error('Connect', [], $pdo_error->getMessage(), false);
        }
    }

    /**
     * Returns the ID of the last insert query
     *
     * @return integer
     **/

    protected function insertId()
    {
        // PDO method lastinsertid is not working for PGSQL
        $sth = $this->con->query('SELECT LASTVAL()');

        $last = $sth->fetch(\PDO::FETCH_ASSOC);

        $result = isset($last['lastval']) ? $last['lastval'] : 0;

        return $result;
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
        $change_pgsql = ['{engine}' => '',
                         '{integer}' => 'integer',
                         '{optimize}' => 'VACUUM',
                         '{serial}' => 'serial',
                         '{text}' => 'text',
                         '{varchar}' => 'varchar'];

        foreach ($change_pgsql AS $key => $pgsql) {

            $replace = str_replace($key, $pgsql, $replace);
        }

        return $replace;
    }

    /**
     * Returns a formatted array with statistics
     *
     * @return array
     **/

    public function info()
    {
        // Get general PDO information
        $info = parent::info();

        // Get encoding of database
        $query    = 'SHOW SERVER_ENCODING';
        $encoding = $this->query($query, [], 0, 0);

        $info['encoding'] = $encoding[0]['server_encoding'];

        // Get size of database
        $query = 'SELECT pg_database_size(\'' . $this->config['schema']
               . '\') AS size';

        $size = $this->query($query, [], 0, 0);

        $info['size'] = (int)$size[0]['size'];

        // Get amount of tables
        $query = 'SELECT COUNT(*) AS tables FROM information_schema.tables '
               . 'WHERE table_name LIKE \'' . $this->config['schema'] . '%\'';

        $tables = $this->query($query, [], 0, 0);

        $info['tables'] = $tables[0]['tables'];

        return $info;
    }
}