<?php

/**
 * List action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   FAQ
 * @author    Daniel Burke <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Get RAD class for this action
$rad = new \csphere\core\rad\Listed('blog');

// Define order columns
$order = ['blog_date'];

// Define closure to execute before finder fetches results
$search = function ($object) {

    $object->join('tags', 'plugin', 'blog_id', 'plugin_fid');
    $object->join('tags', '', 'tag_id', '', 'tags', 'plugin');
    $object->groupBy('faq_id');

    return $object;
};

$rad->callFinder($search);

$rad->search(['blog_title', 'tag_name']);

$rad->delegate('blog_title', $order);