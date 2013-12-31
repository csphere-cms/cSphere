<?php

/**
 * Pattern for edit action
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   RAD
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\rad;

/**
 * Pattern for edit action
 *
 * @category  Core
 * @package   RAD
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Edit extends \csphere\core\rad\Base
{
    /**
     * Action name
     **/
    protected $action = 'edit';

    /**
     * Template file name
     **/
    protected $tpl = 'form';

    /**
     * Previous action
     **/
    protected $previous = 'manage';

    /**
     * Delegate action to run this method
     *
     * @param integer $rid Record ID if not part of URL
     *
     * @return void
     **/

    public function delegate($rid = 0)
    {
        // Get record ID and check for post data
        $record  = (int)$rid;
        $use_rid = 0;

        if (empty($rid)) {

            $record  = (int)\csphere\core\http\Input::get('get', 'id');
            $use_rid = $record;
        }

        $post = \csphere\core\http\Input::getAll('post');

        // Get table model
        $dm_table = new \csphere\core\datamapper\Model($this->plugin, $this->table);
        $table    = $dm_table->read($record);

        // Check if record exists
        if ($table == array()) {

            $this->message('no_record_found', $use_rid, 'red');

        } else {

            // Handle save requests
            if (isset($post['csphere_form'])) {

                // Fill post data into record
                $table = $this->form($table, $post);

                // Get data with record serial
                $serial         = $dm_table->serial();
                $table[$serial] = $record;

                $dm_table->update($table);

                $this->message('record_success', $use_rid, 'green');

            } else {

                // Data array
                $data = array();

                $data[$this->schema] = $table;

                // Send data to view
                $this->view($data, $use_rid);
            }
        }
    }
}