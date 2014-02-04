<?php

/**
 * Provides a layer to records
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
 * Provides a layer to records
 *
 * @category  Core
 * @package   Datamapper
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Model extends \csphere\core\datamapper\Base
{
    /**
     * Create new record
     *
     * @return array
     **/

    public function create()
    {
        $columns = array();

        // Get columns out of structure
        foreach ($this->structure['columns'] AS $col) {

            $columns[$col['name']] = $col['default'];
        }

        return $columns;
    }

    /**
     * Get record by using the serial column
     *
     * @param integer $value  Value to search for, e.g. serial ID
     * @param string  $column Name of a column that is at least unique
     *
     * @return array
     **/

    public function read($value, $column = '')
    {
        // Construct query and fetch result
        if ($column == '') {

            $column = $this->serial;
        }

        $conditions = array(array($column, '=', $value));

        $sql = \csphere\core\sql\DML::select($this->schema, '', '*', $conditions);

        $result = $this->database->query($sql['statement'], $sql['input'], 0, 1);

        return $result;
    }

    /**
     * Insert one record and return it with new ID in serial column
     *
     * @param array $record Record to use for this operation
     *
     * @throws \Exception
     *
     * @return array
     **/

    public function insert(array $record)
    {
        if (empty($record[$this->serial])) {

            // Unset ID column to prevent overcuttings
            unset($record[$this->serial]);

            // Construct query and fetch result
            $sql = \csphere\core\sql\DML::insert($this->schema, $record);

            $rid = $this->database->exec(
                $sql['statement'], $sql['input'], false, true
            );

            // Add back ID column with number
            $record[$this->serial] = $rid;

        } else {

            $msg = 'Serial found in new record for table "' . $this->schema . '"';

            throw new \Exception($msg);
        }

        return $record;
    }

    /**
     * Update one record
     *
     * @param array $record Record to use for this operation
     *
     * @throws \Exception
     *
     * @return boolean
     **/

    public function update(array $record)
    {
        // Set variable for ID column and unset it in record
        $rid = $this->_serial($record);

        unset($record[$this->serial]);

        // Construct query and fetch result
        $sql = \csphere\core\sql\DML::update(
            $this->schema, $record, $this->serial, $rid
        );

        $roa = $this->database->exec($sql['statement'], $sql['input']);

        $result = empty($roa) ? false : true;

        return $result;
    }

    /**
     * Remove one record
     *
     * @param array $record Record to use for this operation
     *
     * @throws \Exception
     *
     * @return boolean
     **/

    public function delete(array $record)
    {
        // Set variable for ID column
        $rid = $this->_serial($record);

        // Construct query and fetch result
        $sql = \csphere\core\sql\DML::delete(
            $this->schema, $this->serial, $rid
        );

        $roa = $this->database->exec($sql['statement'], $sql['input']);

        $result = empty($roa) ? false : true;

        return $result;
    }

    /**
     * Get serial out of a record array
     *
     * @param array $record Record to use for this operation
     *
     * @throws \Exception
     *
     * @return integer
     **/

    private function _serial($record)
    {

        // Check if serial does exist or is below one
        if (empty($record[$this->serial]) || $record[$this->serial] < 1) {

            $msg = 'Invalid serial for record of table "' . $this->schema . '"';

            throw new \Exception($msg);

        } else {

            $serial = $record[$this->serial];
        }

        return $serial;
    }
}