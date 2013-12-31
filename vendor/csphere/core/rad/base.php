<?php

/**
 * Patterns for usual plugin actions
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
 * Patterns for usual plugin actions
 *
 * @category  Core
 * @package   RAD
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Base
{
    /**
     * Plugin name
     **/
    protected $plugin = '';

    /**
     * Database table name
     **/
    protected $table = '';

    /**
     * Database schema name
     **/
    protected $schema = '';

    /**
     * Action name
     **/
    protected $action = '';

    /**
     * Template file name
     **/
    protected $tpl = '';

    /**
     * Service Loader object
     **/
    protected $loader = null;

    /**
     * View driver object
     **/
    protected $view = null;

    /**
     * Previous action
     **/
    protected $previous = '';

    /**
     * Data closure
     **/
    private $_data = null;

    /**
     * Record closure
     **/
    private $_record = null;

    /**
     * Prepare database specific settings
     *
     * @param string $plugin Plugin name
     * @param string $table  Database table name if it differs from plugin name
     *
     * @return \csphere\core\rad\Base
     **/

    public function __construct($plugin, $table = '')
    {
        // Set class options
        $this->plugin = $plugin;
        $this->table  = $table;
        $this->schema = $plugin;

        if (!empty($table)) {

            $this->schema .= '_' . $table;
        }

        // Get important objects
        $this->loader = \csphere\core\service\Locator::get();
        $this->view   = $this->loader->load('view');
    }

    /**
     * Set template specific settings
     *
     * @param string $action   Action name if it differs from method name
     * @param string $tpl      Template file name
     * @param string $previous Adds the previous action to breadcrumb
     *
     * @return boolean
     **/

    public function map($action = '', $tpl = '', $previous = '')
    {
        $this->action   = $action;
        $this->tpl      = $tpl;
        $this->previous = $previous;
    }

    /**
     * If only a message is required for output
     *
     * @param string  $key  Key for translation in default plugin
     * @param integer $rid  Record ID if important for URL
     * @param string  $type Type of message: default, red, green
     *
     * @return void
     **/

    protected function message($key, $rid = 0, $type = 'default')
    {
        // Get message and action from translation
        $msg = \csphere\core\translation\Fetch::key('default', $key);
        $act = \csphere\core\translation\Fetch::exists('default', $this->action);

        $plugin = ($act == true) ? 'default' : $this->plugin;

        $act = \csphere\core\translation\Fetch::key($plugin, $this->action);
        $plg = \csphere\core\translation\Fetch::key($this->plugin, $this->plugin);

        $previous = \csphere\core\url\Link::href(
            $this->plugin, $this->previous
        );

        // Data array
        $data = array('action_name' => $act,
                      'plugin_name' => $plg,
                      'message'     => $msg,
                      'previous'    => $previous,
                      'type'        => $type);

        // Change template file and send to view method
        $this->tpl = 'message';

        $this->view($data, $rid, true);
    }

    /**
     * Send data array to template file
     *
     * @param array   $data Data as an array
     * @param integer $rid  Record ID if important for URL
     * @param boolean $skip Wether to skip the callback
     *
     * @return void
     **/

    protected function view(array $data, $rid = 0, $skip = false)
    {
        // Set breadcrumb
        $bread = new \csphere\core\template\Breadcrumb($this->plugin);

        if ($this->previous != '') {

            $bread->add($this->previous);
        }

        $url = $this->plugin . '/' . $this->action;

        if (!empty($rid)) {

            $url .= '/id/' . (int)$rid;
        }

        // Add current action and build trace list
        $bread->add($this->action, $url);
        $bread->trace();

        // Set action
        $data['action'] = $this->action;

        // Apply registered closure
        if ($skip != true AND is_callable($this->_data)) {

            $func = call_user_func($this->_data, $data[$this->schema]);

            $data[$this->schema] = $func;
        }

        $plugin = $this->tpl == 'message' ? 'default' : $this->plugin;

        // Pass data to template
        $this->view->template($plugin, $this->tpl, $data);
    }

    /**
     * Record data should be replaced with new content of form submit
     *
     * @param array $record Record as an array
     * @param array $new    New content as an array
     *
     * @return array
     **/

    protected function form(array $record, array $new)
    {
        // Move new data into record array
        $record = array_merge($record, $new);

        unset($record['csphere_form']);

        // Apply registered closure
        if (is_callable($this->_record)) {

            $record = call_user_func($this->_record, $record);
        }

        return $record;
    }

    /**
     * Set closure for template data
     *
     * @param \Closure $closure Closure
     *
     * @return boolean
     **/

    public final function callData($closure)
    {
        $result = false;

        if ($closure instanceof \Closure) {

            $this->_data = $closure;

            $result = true;
        }

        return $result;
    }

    /**
     * Set closure for record data
     *
     * @param \Closure $closure Closure
     *
     * @return boolean
     **/

    public final function callRecord($closure)
    {
        $result = false;

        if ($closure instanceof \Closure) {

            $this->_record = $closure;

            $result = true;
        }

        return $result;
    }
}