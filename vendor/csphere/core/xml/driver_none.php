<?php

/**
 * Provides XML file handling for unknown schemas
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
 * Provides XML file handling for unknown schemas
 *
 * @category  Core
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_None extends Base
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
        unset($type, $name, $lang);

        return '';
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
        return $array;
    }
}