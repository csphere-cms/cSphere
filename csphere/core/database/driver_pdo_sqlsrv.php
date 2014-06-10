<?php

/**
 * Adds support for Microsoft SQLSRV databases
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
 * Adds support for Microsoft SQLSRV databases
 *
 * @category  Core
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_PDO_SQLSRV extends Base_PDO
{
    /**
     * Creates the database handler object
     *
     * @param array $config Configuration details as an array
     *
     * @throws \Exception
     *
     * @return \csphere\core\database\Driver_PDO_SQLSRV
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        if (!extension_loaded('pdo_sqlsrv')) {

            throw new \Exception('Extension "pdo_sqlsrv" not found');
        }

        $dsn = empty($config['host']) ? '' :
               'server=' . $config['host'] . '; ';

        // This adds support for passing the db file thats used
        if (!empty($config['file'])) {

            $file = \csphere\core\init\path()
                  . 'csphere/database/' . $config['file'];

            $dsn .= 'AttachDBFileName=' . $file . '; ';
        }

        $dsn .= 'Database=' . $config['schema'];

        $options = [];

        // Use try catch to hide connection details
        try {

            $this->con = new \PDO(
                'sqlsrv:' . $dsn, $config['username'],
                $config['password'], $options
            );

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
        // This works since Microsoft SQL Server 2012
        $string = 'OFFSET ' . (int)$first . ' ROWS '
                . 'FETCH NEXT ' . (int)$max . ' ROWS ONLY';

        // Fix for selecting one result row without using ORDER BY
        if ($max == 1) {

            $string = 'ORDER BY NEWID() ' . $string;
        }

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
        $change_sqlsrv = ['{engine}' => '',
                          '{integer}' => 'int',
                          '{serial}' => 'int IDENTITY(1,1)',
                          '{text}' => 'text',
                          '{longtext}' => 'text',
                          '{varchar}' => 'varchar'];

        foreach ($change_sqlsrv AS $key => $sqlsrv) {

            $replace = str_replace($key, $sqlsrv, $replace);
        }

        // There is no support for manual table optimizations
        $replace = preg_replace("={optimize}(.*?[;])=si", '', $replace);

        // Workaround to have a check for existing tables
        $pattern = "=^DROP TABLE IF EXISTS ([\S]*?)$=si";
        $rewrite = "IF (SELECT COUNT(*) FROM sysobjects WHERE type = 'U'"
                 . " AND name = '\\1') > 0 DROP TABLE \\1";

        $replace = preg_replace($pattern, $rewrite, $replace);

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

        // Client should be an array in this driver extension
        if (is_array($info['client'])) {

            $info['client'] = $info['client']['DriverVer'] . ' (ext '
                            . $info['client']['ExtensionVer'] . ')';
        }

        // Get encoding of database
        $query = 'SELECT collation_name AS encoding FROM sys.databases '
               . 'WHERE database_id = DB_ID()';

        $encoding = $this->query($query, [], 0, 0);

        $info['encoding'] = 'Collation ' . $encoding[0]['encoding'];

        // Get size of database
        $query = 'SELECT SUM(size) AS size FROM sys.master_files '
               . 'WHERE type = 0 AND database_id = DB_ID() GROUP BY database_id';

        $size = $this->query($query, [], 0, 0);

        $info['size'] = $size[0]['size'] * 8192;

        // Get amount of tables
        $query = 'SELECT COUNT(*) AS tables FROM information_schema.tables '
               . 'WHERE table_type = \'base table\'';

        $tables = $this->query($query, [], 0, 0);

        $info['tables'] = $tables[0]['tables'];

        return $info;
    }
}
