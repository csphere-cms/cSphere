<?php

/**
 * Generate sorting order links
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Pagination
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\pagination;

/**
 * Generate sorting order links
 *
 * @category  Core
 * @package   Pagination
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Order
{
    /**
     * Plugin name
     **/
    private $_plugin;

    /**
     * Action name
     **/
    private $_action;

    /**
     * List of available columns
     **/
    private $_columns;

    /**
     * Current sorting order
     **/
    private $_active;

    /**
     * Reverse order if set to true
     **/
    private $_desc = false;

    /**
     * Additional parameters for url
     **/
    private $_params = array();

    /**
     * Arrow down content
     **/
    private $_arrowDown = '';

    /**
     * Arrow up content
     **/
    private $_arrowUp = '';

    /**
     * Start a new order generator
     *
     * @param string  $plugin  Plugin name
     * @param string  $action  Action name
     * @param array   $columns Allowed columns as an array
     * @param string  $default Column to order by default
     * @param boolean $desc    Use reverse order for default sorting
     *
     * @return \csphere\core\pagination\Order
     **/

    public function __construct(
        $plugin, $action, array $columns, $default, $desc = false
    ) {
        // Store settings
        $this->_plugin  = $plugin;
        $this->_action  = $action;
        $this->_columns = $columns;
        $this->_active  = $default;
        $this->_desc    = $desc;

        // Get active order and desc setting
        $get_active = \csphere\core\http\Input::get('get', 'order');
        $get_desc   = \csphere\core\http\Input::get('get', 'desc');

        if (in_array($get_active, $this->_columns)) {

            $this->_active = $get_active;

            if ($get_desc == 1) {

                $this->_desc = true;

            } else {

                $this->_desc = false;
            }
        }
    }

    /**
     * Generate array of order urls
     *
     * @return array
     **/

    public function urls()
    {
        $params = $this->_params;

        $urls = array();

        // Create list of usable urls
        foreach ($this->_columns AS $col) {

            $params['order'] = $col;
            $params['desc'] = '';

            if ($col == $this->_active AND $this->_desc == false) {

                $params['desc'] = 1;
            }

            $urls[$col] = \csphere\core\url\Link::href(
                $this->_plugin, $this->_action, $params
            );
        }

        return $urls;
    }

    /**
     * Generate array of arrows for sort directions
     *
     * @return array
     **/

    public function arrows()
    {
        // Check if arrows are cached
        if ($this->_arrowUp == '') {

            $this->_getArrows();
        }

        $arrows = array();

        // Create list of arrows
        foreach ($this->_columns AS $col) {

            $var = '';

            // Only add arrow to active column
            if ($col == $this->_active) {

                $var = $this->_arrowUp;

                // Change direction for ASC
                if ($this->_desc == false) {

                    $var = $this->_arrowDown;
                }
            }

            $arrows[$col] = $var;
        }

        return $arrows;
    }

    /**
     * Get active column
     *
     * @return string
     **/

    public function active()
    {
        return $this->_active;
    }

    /**
     * Get desc setting for active column
     *
     * @return boolean
     **/

    public function desc()
    {
        return $this->_desc;
    }

    /**
     * Set additional parameters
     *
     * @param array $params Parameters as an array of key value pairs
     *
     * @return boolean
     **/

    public function params(array $params)
    {
        $this->_params = $params;

        return true;
    }

    /**
     * Get up and down arrow
     *
     * @return void
     **/

    private function _getArrows()
    {
        // Get arrows from cache
        $pre    = 'pagination_order_';
        $loader = \csphere\core\service\Locator::get();
        $cache  = $loader->load('cache');

        $this->_arrowUp   = $cache->load($pre . 'up');
        $this->_arrowDown = $cache->load($pre . 'down');

        // Create arrow cache entries otherwise
        if ($this->_arrowUp == false) {

            $view = $loader->load('view');

            // Send data to view and fetch box result
            $view->template('default', 'core_order', array('sort' => 'up'), true);
            $this->_arrowUp = $view->box();
            $view->template('default', 'core_order', array('sort' => 'down'), true);
            $this->_arrowDown = $view->box();

            // Save arrows to cache
            $cache->save($pre . 'up', $this->_arrowUp);
            $cache->save($pre . 'down', $this->_arrowDown);
        }
    }
}