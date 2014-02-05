<?php

/**
 * Visits action
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
$rad = new \csphere\core\rad\Listed('users', 'logins');

$rad->map('visits', 'visits', 'home');

// Define closure to execute before finder fetches results
$session = new \csphere\core\session\Session();
$user_id = (int)$session->get('user_id');

$finder = function ($object) use ($user_id) {

    $object->where('user_id', '=', $user_id);

    return $object;
};

$rad->callFinder($finder);

// Define closure to execute before data is send to template
$data = function ($array) {

    $new = [];

    // Scan for browser and system info
    foreach ($array AS $login) {

        $browser = \csphere\plugins\users\classes\Agent::browser(
            $login['login_browser']
        );
        $system  = \csphere\plugins\users\classes\Agent::system(
            $login['login_browser']
        );

        // Add scan result to data array
        $scan  = ['scan_browser' => $browser . ' - ' . $system];
        $new[] = array_merge($login, $scan);
    }

    return $new;
};

$rad->callData($data);

// Define order columns
$order = ['login_browser', 'login_since'];

$rad->search(['login_browser']);
$rad->delegate('login_since', $order, true);