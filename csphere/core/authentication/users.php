<?php

/**
 * Login support for users plugin
 *
 * PHP Version 5
 *
 * @category  Authentication
 * @package   Users
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\authentication;

/**
 * Login support for users plugin
 *
 * @category  Authentication
 * @package   Users
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Users
{
    /**
     * Session object
     **/
     private $_session = null;

    /**
     * Datamapper object for users table
     **/
     private $_mapper = null;

    /**
     * Prepare values that are needed for later usage
     *
     * @return \csphere\core\authentication\Users
     **/

    public function __construct()
    {
        // Create session and user table datamapper object
        $this->_mapper  = new \csphere\core\datamapper\Model('users');
        $this->_session = new \csphere\core\session\Session();
    }

    /**
     * Wether someone is logged in at the moment
     *
     * @return boolean
     **/

    public function status()
    {
        // Check if user is still logged in
        $result  = false;
        $user_id = $this->_session->get('user_id');

        if (!empty($user_id)) {

            // Get user active info and check for existence
            $user = $this->_mapper->read($user_id, 'user_id');

            if (empty($user['user_active'])) {

                // Kick user auth
                $this->logout();

            } else {

                $result = true;
            }
        }

        return $result;
    }

    /**
     * Attempt to authenticate a user
     *
     * @param string $name     User name
     * @param string $password User password
     *
     * @return boolean
     **/

    public function login($name, $password)
    {
        // Get user from database
        $user   = $this->_mapper->read($name, 'user_name');
        $verify = false;

        // Verify password if both vars are not empty
        if (isset($user['user_password']) && !empty($password)) {

            $verify = \csphere\core\authentication\Password::compare(
                $password, $user['user_password']
            );
        }

        // Only grant access if password check is true
        if ($verify === true) {

            $this->_newLogin($user);
        }

        return $verify;
    }

    /**
     * Update content on fresh logins
     *
     * @param array $user Array with user data
     *
     * @return void
     **/

    private function _newLogin(array $user)
    {
        // Set session data
        $this->_session->set('user_id', $user['user_id']);
        $this->_session->set('user_name', $user['user_name']);
        $this->_session->set('user_lang', $user['user_lang']);

        // Notify users_logins about new visit
        $web  = \csphere\core\http\Input::get('server', 'HTTP_USER_AGENT');
        $time = time();

        $dm_logins = new \csphere\core\datamapper\Model('users', 'logins');
        $login     = $dm_logins->create();

        $login['user_id']       = $user['user_id'];
        $login['login_since']   = $time;
        $login['login_browser'] = $web;

        $dm_logins->insert($login);

        // Update date of last login
        $update = ['user_id' => $user['user_id'], 'user_laston' => $time];

        $this->_mapper->update($update);
    }

    /**
     * Clear session data
     *
     * @return boolean
     **/

    public function logout()
    {
        // Destroy current session
        $this->_session->destroy();

        return true;
    }
}
