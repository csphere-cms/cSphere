<?php

/**
 * Provides XML file handling for changelog schemas
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
 * Provides XML file handling for changelog schemas
 *
 * @category  Core
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_Changelog extends Base
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

        // Changelog file can be part of a theme or plugin
        if ($type == 'plugin') {

            $file = 'csphere/plugins/' . $name . '/changelog.xml';

        } elseif ($type == 'theme') {

            $file = 'csphere/themes/' . $name . '/changelog.xml';
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
        // Shorten array depth for simple elements
        $array['history'] = $array['history'][0];

        if (isset($array['updates'])) {

            // Shorten array depth for array elements
            $array['updates'] = $array['updates'][0]['update'];

            // Shorten updates as good as possible
            $updates_c = count($array['updates']);

            for ($i = 0; $i < $updates_c; $i++) {

                $array['updates'][$i] = $this->_update($array['updates'][$i]);
            }
        }

        // Move attr content to main array
        $array['updates'] = $this->loopattr($array['updates']);

        return $array;
    }

    /**
     * Change data updates sub-array for easier usage
     *
     * @param array $update One update out of the data array
     *
     * @return array
     **/

    private function _update(array $update)
    {
        // Shorten info and instructions
        $update['information']  = $update['information'][0]['value'];
        $update['instructions'] = $update['instructions'][0]['value'];

        // Shorten optional data: added, reworked, fixed, removed
        if (isset($update['added'][0]['item'])) {

            $update['added'] = $update['added'][0]['item'];
        } else {

            $update['added'] = [];
        }

        if (isset($update['reworked'][0]['item'])) {

            $update['reworked'] = $update['reworked'][0]['item'];
        } else {

            $update['reworked'] = [];
        }

        if (isset($update['fixed'][0]['item'])) {

            $update['fixed'] = $update['fixed'][0]['item'];
        } else {

            $update['fixed'] = [];
        }

        if (isset($update['removed'][0]['item'])) {

            $update['removed'] = $update['removed'][0]['item'];
        } else {

            $update['removed'] = [];
        }

        return $update;
    }
}
