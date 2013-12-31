<?php

/**
 * User menu details
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Users
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\plugins\users\classes;

/**
 * User menu details
 *
 * @category  Plugins
 * @package   Users
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Menu
{
    /**
     * User menu if login was passed
     *
     * @param boolean $box If view target area is a box
     *
     * @return void
     **/

    public static function show($box = false)
    {
        // Get view object
        $loader = \csphere\core\service\Locator::get();
        $view   = $loader->load('view');

        // Get user details from session
        $session = new \csphere\core\session\Session();

        // Set template content
        $data = array('user_name' => $session->get('user_name'),
                      'user_id'   => $session->get('user_id'));

        // Box mode needs a different tpl file
        if ($box == false) {

            $view->template('users', 'login_menu', $data);

        } else {

            $view->template('users', 'box_login_menu', $data, true);
        }
    }
}