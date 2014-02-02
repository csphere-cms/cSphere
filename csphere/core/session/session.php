<?php

/**
 * Provides a session with a client to work with
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Session
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\session;

/**
 * Provides a session with a client to work with
 *
 * @category  Core
 * @package   Session
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Session
{

    /**
     * Creates a new session object
     *
     * @return \csphere\core\session\Session
     **/

    public function __construct()
    {
        // Check for an active session
        $status = session_status();

        $active = ($status == PHP_SESSION_ACTIVE) ? true : false;

        // If there is no active session create one
        if (empty($active)) {

            $this->_start();
        }
    }

    /**
     * Cares about session settings and starts a new one
     *
     * @return void
     **/

    private function _start()
    {
        // Set some session settings, httponly is set by cookie_params
        ini_set('session.use_trans_sid', 0);
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);

        // Change session name and cookie params
        $request = \csphere\core\http\Request::get();

        $dns = ($request['dns'] == 'localhost') ? '' : $request['dns'];

        $name = 'csphere_' . md5($request['dns'] . $request['dirname']);

        session_name($name);

        $secure = ($request['protocol'] == 'https') ? true : false;

        session_set_cookie_params(0, $request['dirname'], $dns, $secure, true);

        // Start a new session
        session_start();
    }

    /**
     * Clears all session data
     *
     * @return boolean
     **/

    public function destroy()
    {
        // Empty all session contents
        session_unset();
        session_destroy();

        // Disable future changes
        session_write_close();

        // Get a new id to kill the old one for sure
        session_regenerate_id(true);

        return true;
    }

    /**
     * Retrieves the data stored in a session
     *
     * @param string $name Name of the session key to retrieve
     *
     * @return string
     **/

    public function get($name)
    {
        $string = '';

        if (isset($_SESSION[$name])) {

            $string = $_SESSION[$name];
        }

        return $string;
    }

    /**
     * Stores session data
     *
     * @param string $name  Name of the session key to set
     * @param string $value The value of the session key
     *
     * @return boolean
     **/

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;

        return true;
    }
}