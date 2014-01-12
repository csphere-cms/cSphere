<?php

/**
 * Pattern for options action
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
 * Pattern for options action
 *
 * @category  Core
 * @package   RAD
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Options extends \csphere\core\rad\Base
{
    /**
     * Action name
     **/
    protected $action = 'options';

    /**
     * Template file name
     **/
    protected $tpl = 'options';

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
        // Switch schema
        $this->schema = 'options';

        // Check for post data
        $post = \csphere\core\http\Input::getAll('post');

        // Get all options
        $dm_options = new \csphere\core\datamapper\Options($this->plugin);
        $options    = $dm_options->load();

        // Handle save requests
        if (isset($post['csphere_form'])) {

            // Fill post data into record
            $options = $this->form($options, $post);

            // Save all options
            $dm_options->save($options);

            $this->message('options_success', 0, 'green');

        } else {

            // Data array
            $data = array();

            $data['options'] = $options;

            // Send data to view
            $this->view($data);
        }
    }
}