<?php

/**
 * Edit action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Tags
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Tags ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('tags', 'manage');
$bread->add('edit', 'tags/edit/id/' . $id);
$bread->trace();

 // Get RAD class for this action
$rad = new \csphere\core\rad\Edit('tags');

// this closure just for my tests
// my tests
$data = function ($array) {

    /*
     $tag = \csphere\plugins\tags\classes\Tags::existTag("test");
     \csphere\plugins\tags\classes\Tags::useTag("test", "board", 1);

    if(is_array($tag)){
        $array['tag_name'] = \csphere\plugins\tags\classes\Tags::getTags();
    }
    */

    return $array;
};

$rad->callData($data);


// Delegate action
$rad->delegate();
