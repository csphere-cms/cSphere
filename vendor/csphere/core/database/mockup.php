<?php

/**
 * Dummy for PDO connection object
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\database;

/**
 * Dummy for PDO connection object
 *
 * @category  Core
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Mockup
{
    /**
     * Fetch calls to undefined methods
     *
     * @param string $name      Name of the method
     * @param array  $arguments Content of supplied parameters
     *
     * @return boolean
     **/

    public function __call($name, array $arguments)
    {
        $call = $name . ' ( ';

        foreach ($arguments AS $arg) {

            $call .= $arg . ' ';
        }

        $call .= ')';

        unset($call);

        return false;
    }
}