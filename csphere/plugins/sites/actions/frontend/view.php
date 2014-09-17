<?php

/**
 * View action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Sites
 * @author    Daniel Burke and thanks to Martin Ederer <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Get static site ID
$site_id = (int)\csphere\core\http\Input::get('get', 'id');
$site_id = empty($site_id) ? 0 : $site_id;

// Get translation
global $lang;
$lang = \csphere\core\translation\Fetch::keys('sites');

// Get RAD class for this action
$rad = new \csphere\core\rad\View('sites');

// Define closure to execute before data is send to template
$data = function ($array) {
    if ($array['site_publish'] == 1) {
        // if site is activated, add Breadcrumb navigation
        $bread = new \csphere\core\template\Breadcrumb('default');
        $bread->add('default', 'default');
        $url   = 'sites/view/id/' . (int)$array['site_id'];
        $bread->add('', $url, $array['site_title']);
        $bread->trace();
    } else {
        // if site is deactivated, add error message and Breadcrump navigation
        global $lang;
        $array['site_title']   = $lang['error403_title'];
        $array['site_content'] = $lang['error403_description'];
        $array['site_layout']  = 1;
        $bread = new \csphere\core\template\Breadcrumb('default');
        $bread->add('default', 'default');
        $url   = 'sites/view/id/' . (int)$array['site_id'];
        $bread->add('', $url, $array['site_title']);
        $bread->trace();
    }

    $tags = \csphere\plugins\tags\classes\Tags::usedTags('sites', $array['site_id']);
    $array['site_tags'] = $tags;

    return $array;
};
$rad->callData($data);

// Delegate action
$rad->delegate($site_id);
