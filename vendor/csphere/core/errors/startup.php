<?php

/**
 * Tries to continue on startup trouble
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Errors
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\errors;

/**
 * Tries to continue on startup trouble
 *
 * @category  Core
 * @package   Errors
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Startup
{
    /**
     * Necessity begets ingenuity
     *
     * @param array $error Error as an array
     *
     * @return void
     **/

    public static function rescue(array $error)
    {
        // Check if installation is going on
        $plugin = \csphere\core\http\Input::get('get', 'plugin');

        if ($plugin == 'install') {

            $router = new \csphere\core\router\Controller(true);

            $router->execute();

        } else {

            // Inform template engine about the target
            \csphere\core\template\Hooks::route('errors', 'config');

            // Get loader and view
            $loader = \csphere\core\service\Locator::get();
            $view   = $loader->load('view');

            // Format data for template usage
            $data          = array('file' => $error['file']);
            $data['error'] = \csphere\core\translation\Fetch::key(
                'errors', $error['error']
            );

            // Send data to view and fetch result
            $view->template('errors', 'config', $data);

            $router = new \csphere\core\router\Controller();

            $router->execute(true);
        }
    }
}