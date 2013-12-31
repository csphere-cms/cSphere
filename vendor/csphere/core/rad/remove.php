<?php

/**
 * Pattern for remove action
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
 * Pattern for remove action
 *
 * @category  Core
 * @package   RAD
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Remove extends \csphere\core\rad\Base
{
    /**
     * Action name
     **/
    protected $action = 'remove';

    /**
     * Template file name
     **/
    protected $tpl = 'remove';

    /**
     * Previous action
     **/
    protected $previous = 'manage';

    /**
     * Delegate action to run this method
     *
     * @return void
     **/

    public function delegate()
    {
        // Get record ID and sure param
        $record = (int)\csphere\core\http\Input::get('get', 'id');
        $sure   =  \csphere\core\http\Input::get('get', 'sure');

        // Get table model and record
        $dm_table = new \csphere\core\datamapper\Model($this->plugin, $this->table);
        $table    = $dm_table->read($record);

        if ($table == array()) {

            $this->message('no_record_found', $record, 'red');

        } elseif ($sure == 'yes') {

            $serial         = $dm_table->serial();
            $table[$serial] = $record;

            $dm_table->delete($table);

            $this->message('record_deleted', $record, 'green');

        } elseif ($sure == 'no') {

            $this->message('record_cancel', $record);

        } else {

            // Data array
            $data  = array('rid' => $record);

            // Send data to view
            $this->view($data, $record);
        }
    }
}