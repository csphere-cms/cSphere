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

    private $_afterRecord = null;

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

            // after the creation of the dataset we allow some
            // more action by the user. now he can use the id of the
            // just created entry
            if (is_callable($this->_afterRecord)) {

                call_user_func($this->_afterRecord, $data[$this->schema]);

            }

            $this->message('record_success', 0, 'green');

        } else {

            $data[$this->schema] = $table;

            // Send data to view
            $this->view($data);
        }
    }

    /**
     * Set closure for after record data
     * This allows the user to execute code after the record was created. Now
     * he could also use the id of the record that was just created.
     *
     * @param \Closure $closure Closure
     *
     * @return boolean
     **/

    public final function callAfterRecord($closure)
    {
        $result = false;

        if ($closure instanceof \Closure) {

            $this->_afterRecord = $closure;

            $result = true;
        }

        return $result;
    }

}