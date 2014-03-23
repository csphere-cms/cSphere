<?php

/**
 * Pattern for view action
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
 * Pattern for view action
 *
 * @category  Core
 * @package   RAD
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class View extends \csphere\core\rad\Base
{
    /**
     * Action name
     **/
    protected $action = 'view';

    /**
     * Template file name
     **/
    protected $tpl = 'view';

    /**
     * Previous action
     **/
    protected $previous = 'list';

    /**
     * Delegate action to run this method
     *
     * @param integer $rid Record ID if not part of URL
     *
     * @return void
     **/

    public function delegate($rid = 0)
    {
        // Get record ID
        $record  = (int)$rid;
        $use_rid = 0;

        if (empty($rid)) {

            $record  = (int)\csphere\core\http\Input::get('get', 'id');
            $use_rid = $record;
        }

        // Data array
        $data = [];

        // Get record
        $dm_table = new \csphere\core\datamapper\Model($this->plugin, $this->table);

        $data[$this->schema] = $dm_table->read($record);

        if ($data[$this->schema] == []) {

            $this->message('no_record_found', $use_rid, '');

        } else {

            // Send data to view
            $this->view($data, $use_rid);
        }
    }
}
