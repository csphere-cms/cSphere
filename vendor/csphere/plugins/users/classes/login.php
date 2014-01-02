<?php

/**
 * Login form and form processing
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
 * Login form and form processing
 *
 * @category  Plugins
 * @package   Users
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Login
{
    /**
     * Store successful authentications
     **/
     private static $_authed = false;

    /**
     * Show form for login or handle post request
     *
     * @param boolean $box If view target area is a box
     * @param string  $layout Template layout to use
     *
     * @return void
     **/

    public static function form($box = false, $layout = '')
    {
        // Get view object
        $loader = \csphere\core\service\Locator::get();
        $view   = $loader->load('view');

        // Check for HTTPS
        $https = self::_https();

        if ($https === false) {

            $data = self::_httpsInfo();

        } else {

            $data = self::_check();
        }

        // Determine plugin and layout
        $plugin = 'users';

        if ($layout == '' AND $data['tpl'] == 'message') {

            $plugin = 'default';

        } else {

            $data['tpl'] = 'login' . $layout . '_' . $data['tpl'];
        }

        // Pass data to template
        if (self::$_authed === true) {

            \csphere\plugins\users\classes\Menu::show($box);

        } elseif ($box == false) {

            $view->template($plugin, $data['tpl'], $data);

        } else {

            $view->template($plugin, 'box_' . $data['tpl'], $data, true);
        }
    }

    /**
     * Look for HTTPS option and compare with protocol
     *
     * @return boolean
     **/

    private static function _https()
    {
        // Check if logins are HTTPS only
        $dm_options = new \csphere\core\datamapper\Options('users');
        $options    = $dm_options->load();
        $request    = \csphere\core\http\Request::get('request');
        $https      = true;

        if ($options['force_https'] == 1 AND $request != 'https') {

            $https = false;
        }

        return $https;
    }

    /**
     * Show info about HTTPS only mode
     *
     * @return array
     **/

    private static function _httpsInfo()
    {
        // Get request and language content
        $request = \csphere\core\http\Request::get();
        $login   = \csphere\core\translation\Fetch::key('users', 'login');
        $plugin  = \csphere\core\translation\Fetch::key('users', 'users');
        $https   = \csphere\core\translation\Fetch::key('users', 'https_required');

        // Build link for HTTPS version of website
        $link = 'https://' . $request['dns'];

        if (!empty($request['port'])) {

            $link .= ':' . $request['port'];
        }

        $link .= \csphere\core\url\Link::href('users', 'login');

        // Set data for template
        $data = array('tpl'         => 'message',
                      'type'        => 'default',
                      'action_name' => $login,
                      'plugin_name' => $plugin,
                      'box_name'    => $login,
                      'message'     => $https,
                      'previous'    => $link);

        return $data;
    }

    /**
     * Check for login
     *
     * @return array
     **/

    private static function _check()
    {
        // Always set a tpl to not cause errors
        $data = array('tpl'         => 'form',
                      'login_name'  => '',
                      'login_error' => '');

        // Get data if filled in at form
        $post = \csphere\core\http\Input::getAll('post');

        // Check for login name and password
        if (isset($post['login_name']) AND isset($post['login_password'])) {

            $name = (string)$post['login_name'];
            $pwd  = (string)$post['login_password'];

            // Try to authenticate user
            $auth = new \csphere\core\authentication\Users();

            $status = $auth->login($name, $pwd);

            if ($status === true) {

                // Show user menu
                self::$_authed = true;

            } else {

                // Show message for wrong login details
                $data = array('tpl'         => 'form',
                              'login_name'  => $name,
                              'login_error' => 'yes');
            }

        }

        return $data;
    }
}