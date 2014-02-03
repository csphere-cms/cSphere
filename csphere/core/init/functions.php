<?php

/**
 * Defines some basic functionality used by the engine
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Init
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\init;

/**
 * This handles throwed exceptions which are not catched
 *
 * @param \Exception $exception Exception
 *
 * @return void
 **/

function handlerExceptions(\Exception $exception)
{
    // Create instance of error class and submit exception
    $controller = new \csphere\core\errors\Controller($exception);

    unset($controller);
}

/**
 * This handles classic php errors
 *
 * @param int    $errno   Error Number
 * @param string $errstr  Error String
 * @param string $errfile Error File
 * @param int    $errline Error Line
 *
 * @return void
 **/

function handlerErrors($errno, $errstr, $errfile, $errline)
{
    $exception = new \ErrorException($errstr, $errno, 0, $errfile, $errline);

    // Create instance of error class and submit exception plus continue
    $controller = new \csphere\core\errors\Controller($exception, true);

    unset($controller);
}


/**
 * Autoloader fallback for commandline and builtin webserver
 *
 * @param string $class Class
 *
 * @throws \Exception
 *
 * @return void
 **/

function handlerAutoloads($class)
{
    // Class var comes with namespace which makes it easy
    $class = strtolower(str_replace('\\', '/', $class));

    include \csphere\core\init\path() . $class . '.php';
}

/**
 * Check for errors on shutdown
 *
 * @return void
 **/

function handlerShutdown()
{
    // Errors displayed in here cause side-effects
    ini_set('display_errors', 0);

    // Get last error
    $error = error_get_last();

    if (is_array($error)) {

        $exception = new \ErrorException(
            $error['message'], $error['type'], 0, $error['file'], $error['line']
        );

        // Create instance of error class and submit exception
        $controller = new \csphere\core\errors\Controller($exception);

        unset($controller);
    }
}

/**
 * Determine the root directory where index.php is located
 *
 * @return string
 **/

function path()
{
    static $dir = '';

    // Look for the directory outside the csphere namespace
    if (empty($dir)) {
        $dir = str_replace('\\', '/', __DIR__);
        $dir = str_replace('csphere/core/init', '', $dir);
    }

    return $dir;
}

/**
 * Start up engine next to basic function definitions
 *
 * @return void
 **/

function start()
{
    // Report all errors
    ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);

    // Set timezone to UTC so that times are consistent
    date_default_timezone_set('UTC');

    // Get current microtime for performance measurement
    $start = microtime(true);

    // File extensions for autoloads
    spl_autoload_extensions('.php');

    // Console, built-in-webserver and HHVM need some assistance
    $sapi = strtolower(php_sapi_name());
    $need = array('cli', 'cli-server', 'srv');

    if (in_array($sapi, $need)) {

        // Special case for commandline and builtin webserver
        spl_autoload_register(__NAMESPACE__ . '\handlerAutoloads');

    } else {

        spl_autoload_register();
    }

    // Set error and exception handlers
    spl_autoload_call('csphere\core\errors\Controller');
    set_error_handler(__NAMESPACE__ . '\handlerErrors');
    set_exception_handler(__NAMESPACE__ . '\handlerExceptions');
    register_shutdown_function(__NAMESPACE__ . '\handlerShutdown');

    // Read config file and check for errors
    $conf   = new \csphere\core\init\Config();
    $error  = $conf->error();
    $config = $conf->get();

    // Turn on display_errors if debug is activated
    $debug = (empty($config['view']['debug'])) ? 0 : 1;

    ini_set('display_errors', $debug);

    // Check and set config flags
    $config['view']['parsetime'] = $start;

    if (empty($config['view']['driver'])) {

        $config['view']['driver'] = 'html';
        $config['view']['theme']  = 'install';
    }

    // Pass config to service loader
    \csphere\core\service\Locator::start($config);

    // Prepare input for later usage
    \csphere\core\http\Input::prepare();

    // Execute request if no config error was found
    if ($error == array()) {

        $router = new \csphere\core\router\Controller(true);

        $router->execute();

    } else {

        \csphere\core\errors\Startup::rescue($error);
    }
}