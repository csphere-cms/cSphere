<?php

/**
 * Pattern for create action
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
 * Pattern for create action
 *
 * @category  Core
 * @package   RAD
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Create extends \csphere\core\rad\Base
{
    /**
     * Action name
     **/
    protected $action = 'create';

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
     * @return void
     **/

    public function delegate()
    {
        // Check for post data
        $post = \csphere\core\http\Input::getAll('post');

        // Get table model
        $dm_table = new \csphere\core\datamapper\Model($this->plugin, $this->table);
        $table    = $dm_table->create();

        // Data array
        $data = [];

        // Handle save requests
        if (isset($post['csphere_form'])) {

            // Fill post data into record
            $table = $this->form($table, $post);

            // Get data with insert ID
            $data[$this->schema] = $dm_table->insert($table);

            $this->message('record_success', 0, 'green');

        } else {

            $data[$this->schema] = $table;

            // Send data to view
            $this->view($data);
        }
    }
}