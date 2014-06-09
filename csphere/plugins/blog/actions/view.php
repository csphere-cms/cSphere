<?php

/**
 * View action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Blog
 * @author    Daniel Schalla <schalla@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

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
