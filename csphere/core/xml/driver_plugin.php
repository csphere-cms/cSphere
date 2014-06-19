<?php

/**
 * Provides XML file handling for plugin schemas
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
 * Provides XML file handling for plugin schemas
 *
 * @category  Core
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_Plugin extends Base
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

        if ($type == 'plugin') {

            $file = 'csphere/plugins/' . $name . '/plugin.xml';
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
        $array['required'] = $array['required'][0];

        if (isset($array['required']['attr'][0]['php'])) {

            $array['required']['php'] = $array['required']['attr'][0]['php'];
        }

        // Check for required extensions
        if (empty($array['required']['extension'])) {

            $array['required']['extension'] = [];
        }

        // Shorten optional content if found
        if (!isset($array['environment'][0]['needed'])) {

            $array['environment'][0]['needed'] = [];

        } else {

            $env = [];

            foreach ($array['environment'][0]['needed'] AS $needed) {

                if (!isset($needed['version_max'])) {

                    $needed['version_max'] = '';
                }

                $env[] = $needed;

                $array['environment'][0]['needed'] = $env;
            }
        }

        if (!isset($array['environment'][0]['extend'])) {

            $array['environment'][0]['extend'] = [];
        }

        // Handle special case for entries
        if (!isset($array['entries'][0]['target'])) {

            $array['entries'][0]['target'] = [];
        }

        $array['entries'] = $array['entries'][0];

        // Handle access rules
        if (!isset($array['routes'][0])) {

            $array['routes']=[];

        } else {

            $env=[];

            foreach ($array['routes'][0]['define'] AS $action) {
                $env[$action['value']]=$action['type'];
            }

            $array['routes']=$env;
        }

        // Set icon URL
        $array['icon']['url'] = '';

        return $array;
    }
}
