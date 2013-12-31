<?php

/**
 * Profile action
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

 // Get RAD class for this action
$rad = new \csphere\core\rad\Edit('users');

$rad->map('profile', 'profile', 'home');

// Get session data
$session = new \csphere\core\session\Session();
$user_id = (int)$session->get('user_id');

// Define closure to execute before record is send to database
$record = function ($array) {

    // Check for valid password change
    $pwd = false;

    if (!empty($array['password_old'])
        AND !empty($array['password_new'])
        AND ($array['password_new'] === $array['password_confirm'])
    ) {
        // Old password must pass verification
        $pwd = \csphere\core\authentication\Password::compare(
            $array['password_old'], $array['user_password']
        );
    }

    // Update passwort or remove it from array
    if ($pwd === true) {

        $new = \csphere\core\authentication\Password::hash($array['password_new']);

        $array['user_password'] = $new;

    } else {

        unset($array['user_password']);
    }

    unset($array['password_old']);
    unset($array['password_new'], $array['password_confirm']);

    return $array;
};

$rad->callRecord($record);

// Define closure to execute before data is send to template
$data = function ($array) {

    unset($array['user_password']);

    return $array;
};

$rad->callData($data);

// Delegate action
$rad->delegate($user_id);