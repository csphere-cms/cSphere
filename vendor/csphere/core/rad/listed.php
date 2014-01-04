<?php

/**
 * Pattern for list action
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
 * Pattern for list action
 *
 * @category  Core
 * @package   RAD
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Listed extends \csphere\core\rad\Base
{
    /**
     * Action name
     **/
    protected $action = 'list';

    /**
     * Template file name
     **/
    protected $tpl = 'list';

    /**
     * Search columns
     **/
    private $_like = array();

    /**
     * Link to create
     **/
    private $_create = false;

    /**
     * Link to options
     **/
    private $_options = false;

    /**
     * Finder closure
     **/
    private $_findercall = null;

    /**
     * Set closure for datamapper finder object
     *
     * @param \Closure $closure Closure
     *
     * @return boolean
     **/

    public final function callFinder($closure)
    {
        $result = false;

        if ($closure instanceof \Closure) {

            $this->_findercall = $closure;

            $result = true;
        }

        return $result;
    }

    /**
     * Set search input columns for queries
     *
     * @param array   $like    Column names for search input
     * @param boolean $options Wether a link to options should be shown
     * @param boolean $create  Wether a link to creation should be shown
     *
     * @return boolean
     **/

    public function search(array $like, $create = false, $options = false)
    {
        $this->_like = $like;

        $this->_create  = (boolean)$create;
        $this->_options = (boolean)$options;

        return true;
    }

    /**
     * Apply closure to datamapper finder object
     *
     * @param \csphere\core\datamapper\Finder $finder Finder object
     * @param string                          $search Search string
     *
     * @return \csphere\core\datamapper\Finder
     **/

    private function _finder(\csphere\core\datamapper\Finder $finder, $search = '')
    {
        // Apply registered closure
        if (is_callable($this->_findercall)) {

            $finder = call_user_func($this->_findercall, $finder);
        }

        // Add where conditions and concat them with OR instead of AND
        if ($search != '') {

            foreach ($this->_like AS $col) {

                $finder->where($col, 'like', '%' . $search . '%', false, true);
            }
        }

        return $finder;
    }

    /**
     * Delegate action to run this method
     *
     * @param string  $sort    Column name for default sorting order
     * @param array   $columns Array of columns that can be used for sorting
     * @param boolean $desc    Use reverse order for default sorting
     *
     * @return void
     **/

    public function delegate($sort, array $columns = array(), $desc = false)
    {
        // Set page limit
        $limit = 10;

        // Get search string
        $search = \csphere\core\http\Input::get('post', 'search');

        if ($search == '') {

            $search = \csphere\core\http\Input::get('get', 'search');
        }

        // Set columns if array is empty
        if ($columns == array()) {

            $columns = array($sort);
        }

        // Data array
        $data = array('search' => $search);

        // Count amount of entries
        $fn_table = new \csphere\core\datamapper\Finder($this->plugin, $this->table);
        $fn_table = $this->_finder($fn_table);
        $data['records'] = $fn_table->count();

        $fn_table = $this->_finder($fn_table, $search);
        $data['hits'] = $fn_table->count();

        // Sorting order
        $order = new \csphere\core\pagination\Order(
            $this->plugin, $this->action, $columns, $sort, $desc
        );

        $order->params(array('search' => $search));

        $data['order'] = $order->urls();
        $data['arrow'] = $order->arrows();

        // Get selected page
        $hits  = $data['hits'];
        $pages = new \csphere\core\pagination\Pages(
            $this->plugin, $this->action, $hits, $limit
        );

        $params = array('search' => $search,
                        'order'  => $order->active(),
                        'desc'   => $order->desc());

        $pages->params($params);

        $data['pages'] = $pages->navigation();

        // Get records
        $fn_table->orderBy($order->active(), $order->desc());

        $fn_table = $this->_finder($fn_table, $search);

        $data[$this->schema] = $fn_table->find($pages->offset(), $limit);

        // Set buttons for create and options
        $create          = $this->_create === false ? '' : 'yes';
        $options         = $this->_options === false ? '' : 'yes';
        $data['buttons'] = array('options' => $options, 'create' => $create);

        // Send data to view
        $this->view($data);
    }
}