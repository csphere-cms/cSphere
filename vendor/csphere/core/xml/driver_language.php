<?php

/**
 * Provides XML file handling for language schemas
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\xml;

/**
 * Provides XML file handling for language schemas
 *
 * @category  Core
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_Language extends Base
{
    /**
     * Determine the driver specific source file
     *
     * @param string $type Type of target, e.g. plugin
     * @param string $name Directory name of the target
     * @param string $lang Language if more than one is possible
     *
     * @return string
     **/

    protected function file($type, $name, $lang)
    {
        $file = '';

        // Language file can be part of a theme or plugin
        if ($type == 'plugin') {

            $file = 'csphere/plugins/' . $name . '/languages/' . $lang . '.xml';

        } elseif ($type == 'theme') {

            $file = 'csphere/themes/' . $name . '/languages/' . $lang . '.xml';
        }

        return $file;
    }

    /**
     * Change data array for easier usage
     *
     * @param array $array Formated array generated earlier
     *
     * @return array
     **/

    protected function change(array $array)
    {
        // Shorten array depth for common elements
        $array = $this->common($array);

        // Shorten array depth for simple elements
        $array['translation'] = $array['translation'][0];

        // Definitions are essential for translations
        if (isset($array['definitions'][0]['define'])) {

            $array['definitions'] = $array['definitions'][0]['define'];
        } else {

            $array['definitions'] = array();
        }

        // Set icon URL
        $array['icon']['url'] = '';

        if ($array['icon']['type'] == 'famfamfam') {

             $array['icon']['url'] = \csphere\core\url\Load::image(
                 'famfamfam', 'flags', $array['icon']['value']
             );
        }

        return $array;
    }
}