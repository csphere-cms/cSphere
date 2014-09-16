<?php

/**
 * Manage list action
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

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('sites', 'manage');
$bread->trace();

// Get RAD class for this action
$rad = new \csphere\core\rad\Listed('sites');

$rad->map('manage', 'manage');

// Define order columns
$order = ['site_title', 'site_publish'];

// Define closure to execute before data is send to template
$data = function ($data) {

    for ($i = 0; $i < count($data); ++$i) {

        // Get record option for sites
        $dm_options = new \csphere\core\datamapper\Options('sites');
        $options    = $dm_options->load();

        $data[$i]['site_title'] = \csphere\core\strings\Format::doStraightShorten(
            $data[$i]['site_title'], $options['title_length_manage']
        );

        $data[$i]['site_tags']
            = \csphere\plugins\tags\classes\Tags::usedTagsNamesAsString(
                'sites', $data[$i]['site_id']
            );

    }

    return $data;
};

$rad->callData($data);

// Define closure to execute before finder fetches results
$search = function ($object) {

    \csphere\plugins\tags\classes\Tags::joinTags($object, "site");
    $object->groupBy('site_id');

    return $object;
};

$rad->callFinder($search);

$rad->search(['site_title', 'tag_name'], true, true);

// Delegate action
$rad->delegate('site_id', $order);
