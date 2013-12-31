<?php

/**
 * Adds support for MySQL databases
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
 * Adds support for MySQL databases
 *
 * @category  Core
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_PDO_MYSQL extends Base
{
    /**
     * Defines the drivers function name for a random ORDER BY
     **/

    protected $random = 'RAND()';

    /**
     * Creates the database handler object
     *
     * @param array $config Configuration details as an array
     *
     * @throws \Exception
     *
     * @return \csphere\core\database\Driver_PDO_MYSQL
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        if (!extension_loaded('pdo_mysql')) {

            throw new \Exception('Extension "pdo_mysql" not found');
        }

        // Set prefix for tables
        $this->prefix = $this->config['prefix'];
    }

    /**
     * Establishes the connection with the database
     *
     * @return void
     **/

    protected function connect()
    {
        $dsn = empty($this->config['host']) ? '' :
               'host=' . $this->config['host'] . ';';

        $dsn .= 'dbname=' . $this->config['schema'];

        $options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

        // Use try catch to hide connection details
        try {

            $this->con = new \PDO(
                'mysql:' . $dsn, $this->config['username'],
                $this->config['password'], $options
            );

            $this->con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch(\PDOException $pdo_error) {

            $this->error('Connect', array(), $pdo_error->getMessage(), false);
        }
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
        $string = 'LIMIT ' . (int)$first . ',' . (int)$max;

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
        // Use InnoDB as default storage engine
        $engine = ' ENGINE=innodb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

        $change_mysql = array('{engine}' => $engine,
                              '{integer}' => 'integer',
                              '{optimize}' => 'OPTIMIZE TABLE',
                              '{serial}' => 'integer NOT NULL auto_increment',
                              '{text}' => 'text',
                              '{varchar}' => 'varchar'
        );

        foreach ($change_mysql AS $key => $mysql) {

            $replace = str_replace($key, $mysql, $replace);
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
        $query = 'SHOW VARIABLES WHERE Variable_name = \'character_set_server\'';

        $encoding = $this->query($query, array(), 0, 0);

        $info['encoding'] = $encoding[0]['Value'];

        // Get size of database and amount of tables
        $query = 'SHOW TABLE STATUS LIKE \''
               . $this->config['prefix'] . '%\'';

        $tables = $this->query($query, array(), 0, 0);

        $info['tables'] = count($tables);
        $info['size']   = 0;

        foreach ($tables AS $table) {

            $info['size'] += $table['Data_length'];
        }

        return $info;
    }
}