<?php

/**
 * If finder class is not powerful enough use this one
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Datamapper
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\datamapper;

/**
 * If finder class is not powerful enough use this one
 *
 * @category  Core
 * @package   Datamapper
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class SQL
{
    /**
     * Database service object
     **/
    private $_database = null;

    /**
     * Prepare values that are needed for later usage
     *
     * @return \csphere\core\datamapper\SQL
     **/

    public function __construct()
    {
        // Get database service object
        $loader = \csphere\core\service\Locator::get();

        $this->_database = $loader->load('database');
    }

    /**
     * Send direct SQL requests to the database
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
        // Pass query to database driver
        $result = $this->_database->query($prepare, $assoc, $first, $max);

        // Handle array dimension for max=1 since db layer uses fetch for that case
        if ($max == 1 AND $result != array()) {

            $result = array($result);
        }

        return $result;
    }
}