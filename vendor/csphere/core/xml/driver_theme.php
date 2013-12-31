<?php

/**
 * Provides XML file handling for theme schemas
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
 * Provides XML file handling for theme schemas
 *
 * @category  Core
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_Theme extends Base
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
        unset($lang);

        $file = '';

        if ($type == 'theme') {

            $file = 'csphere/themes/' . $name . '/theme.xml';
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

        // Shorten array depth for array elements
        $array['contains']  = $array['contains'][0];

        // Shorten optional content if found
        if (!isset($array['environment'][0]['needed'])) {

            $array['environment'][0]['needed'] = array();

        } else {

            $env = array();

            foreach ($array['environment'][0]['needed'] AS $needed) {

                if (!isset($needed['version_max'])) {

                    $needed['version_max'] = '';
                }

                $env[] = $needed;

                $array['environment'][0]['needed'] = $env;
            }
        }

        if (!isset($array['environment'][0]['extend'])) {

            $array['environment'][0]['extend'] = array();
        }

        if (isset($array['media'])) {

            $array['media'] = $array['media'][0];
        }

        // Set icon URL
        $array['icon']['url'] = '';

        return $array;
    }
}