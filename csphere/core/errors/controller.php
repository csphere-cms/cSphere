<?php

/**
 * Handles errors and exceptions
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
 * Handles errors and exceptions
 *
 * @category  Core
 * @package   Errors
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Controller
{
    /**
     * Store service loader for later usage
     **/
    private $_loader = null;

    /**
     * Check and log exception details
     *
     * @param \Exception $exception Exception class object
     * @param boolean    $continue  Try to continue execution afterwards
     *
     * @return \csphere\core\errors\Controller
     **/

    public function __construct(\Exception $exception, $continue = false)
    {
        // Create loader object
        $this->_loader = \csphere\core\service\Locator::get();

        // Log exception details
        $this->_log($exception);

        // Handle displayed details if continue is false
        if ($continue == false) {

            $this->_view($exception);
        }
    }

    /**
     * Logs errors and exceptions that occur
     *
     * @param \Exception $exception Exception class object
     *
     * @return void
     **/

    private function _log(\Exception $exception)
    {
        $msg = 'Message: ' . $exception->getMessage() . "\n"
             . 'Code: ' . $exception->getCode() . "\n"
             . 'File: ' . $exception->getFile() . "\n"
             . 'Line: ' . $exception->getLine();

        $append = "\n" . 'Trace:' . "\n" . $exception->getTraceAsString();

        $log = $this->_loader->load('logs');

        $log->log('errors', $msg, true, $append);
    }

    /**
     * Return the string to attach to the template
     *
     * @return string
     **/

    private function _info()
    {
        // Get view object
        $view = $this->_loader->load('view');

        // Format data for template usage
        $data = [];

        // Send data to view and fetch box result
        $view->template('errors', 'core_info', $data, true);

        $result = $view->box();

        return $result;
    }

    /**
     * Care about what will be shown
     *
     * @param \Exception $exception Exception class object
     *
     * @return void
     **/

    private function _view(\Exception $exception)
    {
        // Create a view
        $template = $this->_loader->load('view');

        // Check if debug is enabled
        $check = $template->getOption('debug');

        if (empty($check)) {

            // Message to display when debug is turned off
            $content = $this->_info();

            // Update route target
            \csphere\core\template\Hooks::route('errors', 'info');

        } else {

            // Message to display when debug is turned on
            $backtrace = new \csphere\core\debug\Backtrace($exception);

            $content = $backtrace->content();

            // Update route target
            \csphere\core\template\Hooks::route('debug', 'backtrace');
        }

        // If there is content display it
        if ($content != '') {

            $template->add($content);

            // Load router without search and skip target file
            $router = new \csphere\core\router\Controller();

            $router->execute(true);
        }
    }
}