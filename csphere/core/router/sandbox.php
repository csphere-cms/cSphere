<?php

/**
 * Executes a target file of a request
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Router
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\router;

/**
 * Executes a target file of a request
 *
 * @category  Core
 * @package   Router
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Sandbox
{
    /**
     * Include a target file
     *
     * @param string $file File name with full path
     *
     * @return boolean
     **/

    public static function run($file)
    {
        // Use output buffer to not get verbose
        ob_start();

        // Hide error messages at this part
        $errors = ini_get('display_errors');
        ini_set('display_errors', 0);

        // Try to include and execute the target file
        try {

            include $file;

        } catch (\Exception $exception) {

            $controller = new \csphere\core\errors\Controller($exception, true);

            unset($controller);
        }

        // Change error messages back to default setting
        ini_set('display_errors', $errors);

        // Clean output buffer
        ob_end_clean();

        return true;
    }
}