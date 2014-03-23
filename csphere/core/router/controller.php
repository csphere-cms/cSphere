<?php

/**
 * Find and execute the best solution for a request
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Router
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\router;

/**
 * Class controller knows best what to do with the request
 *
 * @category  Core
 * @package   Router
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Controller
{
    /**
     * Store plugin with target to use
     **/
    private $_target = '';

    /**
     * Store if the target is a box
     **/
    private $_box = false;

    /**
     * Store if the request expects a json object
     **/
    private $_xhr = false;

    /**
     * Creates a new router for executing a destination
     *
     * @param boolean $search Set this to true to auto discover the target
     *
     * @return \csphere\core\router\Controller
     **/

    public function __construct($search = false)
    {
        // Check for xhr mode that needs a json object
        $xhr = \csphere\core\http\Input::get('get', 'xhr');

        if ($xhr == 1) {

            $this->_xhr = true;
        }

        // Check if search is enabled
        if ($search == true) {

            $this->_search();
        }
    }

    /**
     * Execute the target plugin target
     *
     * @param boolean $skip Whether to skip target execution
     *
     * @return void
     **/

    public function execute($skip = false)
    {
        // Check if response was already send
        $status = \csphere\core\http\Response::status();

        if ($status === false) {

            // If skip is true the view was already filled with content
            if ($skip === false) {

                \csphere\core\router\Sandbox::light($this->_target);
            }

            // Get content from view
            $loader  = \csphere\core\service\Locator::get();
            $view    = $loader->load('view');
            $content = $view->assemble($this->_xhr, $this->_box);

            // Tell response whether to use compression
            $zlib = false;

            if ($skip == false) {

                $zlib = (boolean)$view->getOption('zlib');
            }

            \csphere\core\http\Response::compression($zlib);

            // Send content to response
            \csphere\core\http\Response::send($content);
        }
    }

    /**
     * Gets a target action or box of a plugin
     *
     * @param string $plugin Plugin name
     * @param string $action Action name
     *
     * @return string
     **/

    public function target($plugin, $action)
    {
        $checks = new \csphere\core\plugins\Checks($plugin);
        $checks->setRoute($action);

        // Keep initial action while allowing changes to it
        $new_action = $action;

        // Fallback if action does not exist
        if ($checks->existance() == false) {

            $new_action = 'dispatch';
            $checks->setRoute($new_action);

            // Reset fallback if no plugin dispatcher was found
            if ($checks->existance() == false) {

                $new_action = $action;
                $checks->setRoute($new_action);
            }
        }

        // Inform template engine about the target
        \csphere\core\template\Hooks::route($plugin, $new_action);

        $target = $checks->result();

        return $target;
    }

    /**
     * Gets a target action or box of a plugin
     *
     * @return string
     **/

    private function _search()
    {
        // Fetch important url parameters
        $box    = \csphere\core\http\Input::get('get', 'box');
        $plugin = \csphere\core\http\Input::get('get', 'plugin');
        $action = \csphere\core\http\Input::get('get', 'action');

        // Check for favicon requests
        if ($plugin == 'favicon.ico') {

            $plugin = '';
        }

        // Fetch defaults if no plugin is given
        if (empty($plugin)) {

            $this->_target = $this->_defaults();

        } elseif (!empty($box)) {

            $this->_box = true;

            // Special case for box requests
            $checks = new \csphere\core\plugins\Checks($plugin);
            $checks->setRoute($box, true);
            $this->_target = $checks->result();

        } else {

            // Set action to list if it is empty
            if (empty($action)) {

                $action = 'list';
            }

            $this->_target = $this->target($plugin, $action);
        }
    }

    /**
     * Get default plugin and action from options
     *
     * @return string
     **/

    private function _defaults()
    {
            // @TODO: Use options for start page here
            $plugin = 'default';
            $action = 'list';

            $target = $this->target($plugin, $action);

            return $target;
    }
}
