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
     * Include a target file and control error handling
     *
     * @param string $file File name with full path
     *
     * @return boolean
     **/

    public static function full($file)
    {
        // Use output buffer to not get verbose
        ob_start();

        // Try to include and execute the target file
        try {

            include $file;

        } catch (\Exception $exception) {

            $controller = new \csphere\core\errors\Controller($exception, true);

            unset($controller);
        }

        ob_end_clean();

        return true;
    }

    /**
     * Include a target file without error handling
     *
     * @param string $file File name with full path
     *
     * @return boolean
     **/

    public static function light($file)
    {
        // Use output buffer to not get verbose
        ob_start();

        // Hide error messages at this part
        $errors = ini_get('display_errors');
        ini_set('display_errors', 0);

        include $file;

        // Change error messages back to default setting
        ini_set('display_errors', $errors);

        ob_end_clean();

        return true;
    }
}
