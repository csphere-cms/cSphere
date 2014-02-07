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
    private $_parts = ['joins' => '',
                       'columns' => '*',
                       'where' => [],
                       'order' => [],
                       'group' => [],
                       'having' => []];

     /**
     * Reset layout for parts of a query
     **/
     private $_reset = ['joins' => '',
                        'columns' => '*',
                        'where' => [],
                        'order' => [],
                        'group' => [],
                        'having' => []];

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
     * Removes all entries that match given parameters. The scope can be reduced
     * by using where and join. All other method-interactions might be ignored.
     *
     * @return array
     */
    public function remove()
    {
        // Construct query and fetch result
        $sql = \csphere\core\sql\DML::delete(
            $this->schema,
            $this->_parts['where'],
            $this->_parts['joins']
        );

        $result = $this->database->query(
            $sql['statement'], $sql['input'], 0, 0
        );

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
        if ($this->_parts['order'] == []) {

            $this->_parts['order'] = [$this->serial, 'ASC'];
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
        if ($max == 1 && $result != []) {
            $result = [$result];
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
            'COUNT(DISTINCT( ' . $this->serial . ')) AS count',
            $this->_parts['where']
        );

        $result = $this->database->query(
            $sql['statement'], $sql['input'], 0, 0
        );

        $result = isset($result[0]['count']) ? $result[0]['count'] : 0;

        // Reset parts array
        $this->_parts = $this->_reset;

        return $result;
    }

    /**
     * Add a natural (inner) join to the query. By default the given foreignPlugin
     * and foreignTable are joined with the plugin table. To set another plugin and
     * table that joins the foreign table, you have to use the last two parameters.
     *
     * If the table name is the plugin name then provide an empty string for table.
     *
     * Serial is the key which is used for the join. If no foreign is given the
     * serial key is used for both sides as the column name for the join.
     *
     * @param string $foreignPlugin Foreign Plugin name (the one we want to
     * @param string $foreignTable  Foreign Table name
     * @param string $serial        Serial column name (native table)
     * @param string $foreignColumn Foreign column name (other table)
     * @param string $plugin        Plugin name (the one we already have)
     * @param string $table         Table name (the one we already have)
     *
     * @return \csphere\core\datamapper\Finder
     **/

    public function join(
        $foreignPlugin,
        $foreignTable,
        $serial,
        $foreignColumn,
        $plugin = '',
        $table = ''
    ) {
        // Use plugin and table of this object by default
        if ($plugin == '') {

            $plugin = $this->schema;

        } else {

            if ($table != '') {
                $plugin .= '_' . $table;
            }

        }

        // Add foreign table to table name if used
        if ($foreignTable != '') {

            $foreignPlugin .= '_' . $foreignTable;
        }

        $this->_parts['joins'][] = [
            $plugin, $foreignPlugin, $serial, $foreignColumn
        ];

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
        $this->_parts['where'][] = [$column, $operation, $value, $not, $xor];

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
        $this->_parts['order'][] = [$column, $desc];

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

            $list = [$list];
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
        $this->_parts['having'][] = [$column, $operation, $value, $not, $xor];

        return $this;
    }
}