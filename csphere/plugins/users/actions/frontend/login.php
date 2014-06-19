<?php

/**
 * User login panel action
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

// Fetch authentication status
$auth   = new \csphere\core\authentication\Users();
$status = $auth->status();

// Show menu or login form
if ($status === true) {

    \csphere\plugins\users\classes\Menu::show();

} else {

    \csphere\plugins\users\classes\Login::form();
}
