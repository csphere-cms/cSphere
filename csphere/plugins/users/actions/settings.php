<?php

/**
 * Settings action
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

$rad->map('settings', 'settings', 'home');

// Get session data
$session = new \csphere\core\session\Session();
$user_id = (int)$session->get('user_id');

// Get language metadata
$meta = new \csphere\core\translation\Metadata();

// Define closure to execute before record is send to database
$record = function ($array) use ($session) {

    unset($array['user_password']);

    // Update user language inside session
    $session->set('user_lang', $array['user_lang']);

    return $array;
};

$rad->callRecord($record);

// Define closure to execute before data is send to template
$data = function ($array) use ($meta) {

    unset($array['user_password']);

    // Set active language
    $def   = $meta->exists($array['user_lang']) ? $array['user_lang'] : 'en';
    $names = $meta->names();

    $opt = \csphere\core\template\Form::options($names, 'short', 'name', $def);

    $array['languages'] = $opt;

    return $array;
};

$rad->callData($data);

// Delegate action
$rad->delegate($user_id);