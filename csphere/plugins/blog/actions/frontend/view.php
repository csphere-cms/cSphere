<?php

/**
 * View action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Blog
 * @author    Daniel Schalla <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Blog ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('blog', 'list');
$bread->add('view', 'blog/view/id/' . $id);
$bread->trace();

// Get RAD class for this action
$rad = new \csphere\core\rad\View('blog');


// Define closure to execute before data is send to template
$data = function ($data) {

    $tags = \csphere\plugins\tags\classes\Tags::usedTags('blog', $data['blog_id']);
    $data['blog_tags'] = $tags;

    return $data;
};
$rad->callData($data);

// Delegate action
$rad->delegate();
