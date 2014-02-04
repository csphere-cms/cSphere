<?php

/**
 * Provides a layer for select queries
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
 * Provides a layer for select queries
 *
 * @category  Core
 * @package   Datamapper
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Finder extends \csphere\core\datamapper\Base
{
    /**
     * Parts for a query
     **/
    private $_parts = array('joins' => '',
                            'columns' => '*',
                            'where' => array(),
                            'order' => array(),
                            'group' => array(),
                            'having' => array());

     /**
     * Reset layout for parts of a query
     **/
     private $_reset = array('joins' => '',
                             'columns' => '*',
                             'where' => array(),
                             'order' => array(),
                             'group' => array(),
                             'having' => array());

    /**
     * Get first record matching filters
     *
     * @return array
     **/

    public function first()
    {
        // Construct query and fetch result
        $sql = \csphere\core\sql\DML::select(
            $this->schema,
            $this->_parts['joins'],
            $this->_parts['columns'],
            $this->_parts['where'],
            $this->_parts['order'],
            $this->_parts['group'],
            $this->_parts['having']
        );

        $result = $this->database->query($sql['statement'], $sql['input'], 0, 1);

        // Reset parts array
        $this->_parts = $this->_reset;

        return $result;
    }

    /**
     * Find all records matching filters
     *
     * @param integer $first Number of the first dataset to show
     * @param integer $max   Number of datasets to show from first on
     *
     * @return array
     **/

    public function find($first, $max)
    {
        // Sort by serial ascending if nothing else is specified
        if ($this->_parts['order'] == array()) {

            $this->_parts['order'] = array($this->serial, 'ASC');
        }

        // Construct query and fetch result
        $sql = \csphere\core\sql\DML::select(
            $this->schema,
            $this->_parts['joins'],
            $this->_parts['columns'],
            $this->_parts['where'],
            $this->_parts['order'],
            $this->_parts['group'],
            $this->_parts['having']
        );

        $result = $this->database->query(
            $sql['statement'], $sql['input'], $first, $max
        );

        // Handle array dimension for max=1 since db layer uses fetch for that case
        if ($max == 1 && $result != array()) {
            $result = array($result);
        }

        // Reset parts array
        $this->_parts = $this->_reset;

        return $result;
    }

    /**
     * Find amount of records matching filters
     *
     * @return integer
     **/

    public function count()
    {
        // Construct query and fetch result
        $sql = \csphere\core\sql\DML::select(
            $this->schema,
            $this->_parts['joins'],
            'COUNT(*) AS count',
            $this->_parts['where'],
            array(),
            $this->_parts['group'],
            $this->_parts['having']
        );

        $result = $this->database->query($sql['statement'], $sql['input'], 0, 0);

        $result = isset($result[0]['count']) ? $result[0]['count'] : 0;

        // Reset parts array
        $this->_parts = $this->_reset;

        return $result;
    }

    /**
     * Add a natural (inner) join to the query
     *
     * @param string $plugin  Plugin name
     * @param string $table   Table name
     * @param string $serial  Serial column name (native table)
     * @param string $foreign Foreign column name (using table)
     *
     * @return \csphere\core\datamapper\Finder
     **/

    public function join($plugin, $table, $serial, $foreign = '')
    {
        $this->_parts['joins'][] = array($plugin, $table, $serial, $foreign);

        return $this;
    }

    /**
     * Add a where condition to the query
     *
     * @param string  $column    Column name
     * @param string  $operation Operation, e.g. = or !=
     * @param mixed   $value     Value as string or e.g. for BETWEEN as an array
     * @param boolean $not       Negate the condition if set to true
     * @param boolean $xor       Change concatination from AND to OR if set to true
     *
     * @return \csphere\core\datamapper\Finder
     **/

    public function where($column, $operation, $value, $not = false, $xor = false)
    {
        $this->_parts['where'][] = array($column, $operation, $value, $not, $xor);

        return $this;
    }

    /**
     * Define columns for the query
     *
     * @param mixed $list List of columns as a string or an array
     *
     * @return \csphere\core\datamapper\Finder
     **/

    public function columns($list)
    {
        $this->_parts['columns'] = $list;

        return $this;
    }

    /**
     * Add a where condition to the query
     *
     * @param string  $column Column name
     * @param boolean $desc   Start with last record if set to true
     *
     * @return \csphere\core\datamapper\Finder
     **/

    public function orderBy($column, $desc = false)
    {
        $this->_parts['order'][] = array($column, $desc);

        return $this;
    }

    /**
     * Define group by condition for the query
     *
     * @param mixed $list List of columns as a string or as an array
     *
     * @return \csphere\core\datamapper\Finder
     **/

    public function groupBy($list)
    {
        if (!is_array($list)) {

            $list = array($list);
        }

        $this->_parts['group'] = $list;

        return $this;
    }

    /**
     * Add a having condition to the query
     *
     * @param string  $column    Column name
     * @param string  $operation Operation, e.g. = or !=
     * @param mixed   $value     Value as string or e.g. for BETWEEN as an array
     * @param boolean $not       Negate the condition if set to true
     * @param boolean $xor       Change concatination from AND to OR if set to true
     *
     * @return \csphere\core\datamapper\Finder
     **/

    public function having($column, $operation, $value, $not = false, $xor = false)
    {
        $this->_parts['having'][] = array($column, $operation, $value, $not, $xor);

        return $this;
    }
}