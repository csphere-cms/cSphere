<?php

/**
 * Provides logging functionality as a mock-up
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Logs
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\logs;

/**
 * Provides logging functionality as a mock-up
 *
 * @category  Core
 * @package   Logs
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_None extends Base
{
    /**
     * Stores the log content for later usage
     *
     * @param string $component Name of the core component
     * @param string $content   Content to log in this case
     *
     * @return boolean
     **/

    protected function store($component, $content)
    {
        unset($component, $content);

        return true;
    }
}