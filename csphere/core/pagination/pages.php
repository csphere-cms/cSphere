<?php

/**
 * Generate page turn links
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
 * Generate page turn links
 *
 * @category  Core
 * @package   Pagination
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Pages
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
     * Total amount of entries
     **/
    private $_total;

    /**
     * Limit of entries on a page
     **/
    private $_limit;

    /**
     * Page to start from
     **/
    private $_start;

    /**
     * Additional parameters for url
     **/
    private $_params = array();

    /**
     * Start a new page generator
     *
     * @param string $plugin Plugin name
     * @param string $action Action name
     * @param string $total  Amount of entries
     * @param string $limit  Limit of entries per page
     *
     * @return \csphere\core\pagination\Pages
     **/

    public function __construct($plugin, $action, $total, $limit)
    {
        // Store settings
        $this->_plugin = $plugin;
        $this->_action = $action;
        $this->_total  = (int)$total;
        $this->_limit  = (int)$limit;

        // Get start page and make sure its above zero
        $this->_start = (int)\csphere\core\http\Input::get('get', 'page');

        if ($this->_start < 1) {

            $this->_start = 1;
        }
    }

    /**
     * Generate page turn links
     *
     * @param boolean $light  Light version with only last, current and next page
     * @param boolean $arrows Wether or not to attach arrows for page turns
     *
     * @return string
     **/

    public function navigation($light = false, $arrows = true)
    {
        // Set amount of pages and build page navigation
        $pages = ceil($this->_total / $this->_limit);

        // Use full or light mode
        if ($light == true) {

            $data['groups'] = $this->_light($pages);

        } else {

            $end = 3;

            // If there are very few pages end earlier or skip groups
            if ($end > $pages OR $pages < 10) {

                $end = $pages;

            } elseif ($this->_start > 2 AND $this->_start < 6) {

                $end = $this->_start + 1;
            }

            $data['groups'] = $this->_full($pages, $end);
        }

        // Generate template output
        $data['pages'] = $pages;

        $result = $this->_build($data, $arrows);

        return $result;
    }

    /**
     * Generate light layout
     *
     * @param integer $pages Amount of pages
     *
     * @return array
     **/

    private function _light($pages)
    {
        $groups = array();

        // Use current page as default
        $next = $this->_start - 1;
        $end  = $next + 2;

        // Handle special cases
        if ($this->_start == 1) {

            $next = 1;
            $end  = $next + 2;
        }

        if ($pages < 3) {

            $next = 1;
            $end  = $pages;

        } elseif ($this->_start >= $pages) {

            $next = $pages - 2;
            $end  = $pages;
        }

        $first    = $this->_group($next, $end);
        $groups[] = array('links' => $first, 'space' => 'no');

        return $groups;
    }

    /**
     * Generate full layout
     *
     * @param integer $pages Amount of pages
     * @param integer $end   End of first group
     *
     * @return array
     **/

    private function _full($pages, $end)
    {
        $groups = array();

        // Generate first group of links
        $first    = $this->_group(1, $end);
        $groups[] = array('links' => $first, 'space' => 'no');

        // Generate second group of links
        if ($pages > $end AND $end < 4) {

            $middle = $this->_middle($pages);
            $end    = $middle['end'];

            $second   = $this->_group($middle['next'], $end);
            $groups[] = array('links' => $second, 'space' => 'yes');
        }

        // Generate third group of links
        if ($pages > $end) {

            $next = $pages - 2;

            $third    = $this->_group($next, $pages);
            $groups[] = array('links' => $third, 'space' => 'yes');
        }

        return $groups;
    }

    /**
     * Determine page start and end for middle part of full layout
     *
     * @param integer $pages Amount of pages
     *
     * @return array
     **/

    private function _middle($pages)
    {
        // Use current page as default
        $next = floor($pages / 2);
        $end  = $next + 2;

        // Handle special cases
        if ($this->_start > 5 AND $this->_start < ($pages - 1)) {

            $next = $this->_start - 1;
            $end  = $next + 2;

            if ($this->_start > ($pages - 5)) {

                $next = $this->_start - 1;
                $end  = $pages;

                if ($next == ($pages - 1)) {

                    $next--;
                }
            }
        }

        // Build array for group method
        $result = array('next' => $next, 'end' => $end);

        return $result;
    }

    /**
     * Generate a group of links
     *
     * @param integer $start Start page
     * @param integer $end   Last page
     *
     * @return array
     **/

    private function _group($start, $end)
    {
        $params = $this->_params;
        $links  = array();

        // Display at least one page on start
        if ($start == 1 AND $end < 1) {

            $end = 1;
        }

        // Create and concat all links
        for ($i = $start; $i <= $end; $i++) {

            // Check if link is to current page
            if ($i == $this->_start) {

                $links[] = array('page' => $i, 'href' => '', 'active' => 'yes');

            } else {

                // Build href for link
                $params['page'] = $i;

                $href = \csphere\core\url\Link::href(
                    $this->_plugin, $this->_action, $params
                );

                $links[] = array('page' => $i, 'href' => $href, 'active' => 'no');
            }
        }

        return $links;
    }

    /**
     * Generate arrows for navigation
     *
     * @param integer $pages Amount of pages
     *
     * @return array
     **/

    private function _arrows($pages)
    {
        $params = $this->_params;
        $arrows = array();

        // Add << and < arrows
        $arrows['first'] = 1;

        $prev = $this->_start - 1;

        if ($this->_start < 2) {

            $prev = 1;
        }

        $arrows['previous'] = $prev;

        // Add > and >> arrows
        $next = $this->_start + 1;

        if ($next > $pages) {

            $next = $pages;
        }

        $arrows['next'] = $next;

        $arrows['last'] = $pages;

        // Change arrows to links
        foreach ($arrows AS $name => $page) {

            $params['page'] = $page;

            $href = \csphere\core\url\Link::href(
                $this->_plugin, $this->_action, $params
            );

            $arrows[$name] = $href;
        }

        return $arrows;
    }

    /**
     * Create content from template file
     *
     * @param array   $data   Data array for template
     * @param boolean $arrows Wether or not to attach arrows for page turns
     *
     * @return string
     **/

    private function _build(array $data, $arrows)
    {
        $data['arrow'] = array('show' => 'no');

        // Add links for arrows if requested
        if ($arrows == true) {

            $data['arrow'] = $this->_arrows($data['pages']);

            $data['arrow']['show'] = 'yes';
        }


        // Get view driver object
        $loader = \csphere\core\service\Locator::get();
        $view = $loader->load('view');

        // Send data to view and fetch box result
        $view->template('default', 'pages', $data, true);
        $result = $view->box();

        return $result;
    }

    /**
     * Get offset e.g. for database queries
     *
     * @return integer
     **/

    public function offset()
    {
        $offset = ($this->_start - 1) * $this->_limit;

        return $offset;
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
}