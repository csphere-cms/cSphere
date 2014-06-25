<?php

/**
 * Provides XML file handling for database schemas
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
 * Provides XML file handling for access schemas
 *
 * @category  Core
 * @package   XML
 * @author    Daniel Schalla <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_Access extends Base
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

            $file = 'csphere/plugins/' . $name . '/access.xml';
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
        $ret=[];

        foreach ($array['permission'] as $permission){

            if (!isset($permission['attr'][0]['name']) || !isset($permission['type'][0]['value'])) {
                throw new \ErrorException("Malformed Access File of Plugin: ".$this->path);
            }

            $tmp=[];
            $tmp['type']=$permission['type'][0]['value'];

            $ret[$permission['attr'][0]['name']] = $tmp;
        }

        return $ret;
    }

}
