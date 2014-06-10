<?php

/**
 * Adds support for SQLite databases
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
 * Adds support for SQLite databases
 *
 * @category  Core
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_PDO_SQLITE extends Base_PDO
{
    /**
     * Creates the database handler object
     *
     * @param array $config Configuration details as an array
     *
     * @throws \Exception
     *
     * @return \csphere\core\database\Driver_PDO_SQLite
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        if (!extension_loaded('pdo_sqlite')) {

            throw new \Exception('Extension "pdo_sqlite" not found');
        }

        $file = \csphere\core\init\path()
              . 'csphere/storage/database/' . $config['file'];

        $options = [];

        // Use try catch to hide connection details
        try {

            $this->con = new \PDO('sqlite:' . $file, null, null, $options);

            $this->con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch(\PDOException $pdo_error) {

            $this->error('Connect', [], $pdo_error->getMessage(), false);
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
        $change_sqlite = ['{engine}' => '',
                          '{integer}' => 'integer',
                          '{optimize}' => 'VACUUM',
                          '{serial}' => 'integer',
                          '{text}' => 'text',
                          '{longtext}' => 'text',
                          '{varchar}' => 'varchar'];

        foreach ($change_sqlite AS $key => $sqlite) {

            $replace = str_replace($key, $sqlite, $replace);
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
        $encoding = $this->query('PRAGMA encoding', [], 0, 0);

        $info['encoding'] = $encoding[0]['encoding'];

        // Get size of database
        $file = \csphere\core\init\path()
              . 'csphere/storage/database/' . $this->config['file'];

        $info['size'] = filesize($file);

        // Get amount of tables
        $query = 'SELECT COUNT(*) AS tables FROM sqlite_master '
               . 'WHERE type = \'table\' AND name LIKE \''
               . $this->config['prefix'] . '%\'';

        $tables = $this->query($query, [], 0, 0);

        $info['tables'] = $tables[0]['tables'];

        return $info;
    }
}
