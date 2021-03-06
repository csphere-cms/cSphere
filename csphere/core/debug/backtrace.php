<?php

/**
 * Handles backtrace requests to output the content
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Debug
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\debug;

/**
 * Handles backtrace requests to output the content
 *
 * @category  Core
 * @package   Debug
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Backtrace
{
    /**
     * Local file path prefix
     **/
    private $_path = '';

    /**
     * Length in chars to cut from file path
     **/
    private $_cut = 0;

    /**
     * Holds the most current content
     **/
    private $_content = [];

    /**
     * Create traceback for the exception
     *
     * @param \Exception $exception Exception class object
     *
     * @return \csphere\core\debug\Backtrace
     **/

    public function __construct(\Exception $exception)
    {
        // This prepares the file name shortening later on
        $this->_path = \csphere\core\init\path();
        $this->_cut  = strlen($this->_path);

        // Create backtrace content
        $this->_content['error'] = $this->_formatError($exception);
        $this->_content['trace'] = $this->_formatTrace($exception);
    }

    /**
     * Return the string to attach to the template
     *
     * @return string
     **/

    public function content()
    {
        // Get loader and view
        $loader = \csphere\core\service\Locator::get();
        $view   = $loader->load('view');

        // Format data for template usage
        $data = $this->_content;

        // Send data to view and fetch box result
        $view->template('debug', 'core_backtrace', $data, true);

        $result = $view->box();

        return $result;
    }

    /**
     * Format call
     *
     * @param array $call The call data as an array
     *
     * @return string
     **/

    private function _formatCall(array $call)
    {
        $args = '';

        // Check for call details and add most important data
        if (isset($call[0])) {

            foreach ($call AS $data) {

                // Type of data might be interesting
                if (is_object($data)) {

                    $args .= 'Object: ' . get_class($data) . ', ';
                } elseif (is_array($data)) {

                    $args .= 'Array, ';
                } else {

                    $args .= "'" . $data . "', ";
                }
            }

            $args = substr($args, 0, -2);
        }

        return $args;
    }

    /**
     * Format error message
     *
     * @param \Exception $exception Exception class object
     *
     * @return array
     **/

    private function _formatError(\Exception $exception)
    {
        $msg = ['message' => $exception->getMessage(),
                'code'    => $exception->getCode(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine()];

        return $msg;
    }

    /**
     * Format trace
     *
     * @param \Exception $exception Exception class object
     *
     * @return array
     **/

    private function _formatTrace(\Exception $exception)
    {
        $trace = $exception->getTrace();
        $out   = [];
        $count = count($trace);

        // All steps starting with the last one as zero
        for ($back = 0; $back < $count; $back++) {

            $out[] = $this->_formatStep($trace, $back);
        }

        return $out;
    }

    /**
     * Format step
     *
     * @param array   $trace Trace as an array
     * @param integer $back  Number of target step
     *
     * @return array
     **/

    private function _formatStep(array $trace, $back)
    {
        $args = '';
        $call = '';

        // Check if details are available
        if (isset($trace[$back]['args'])) {

            $args = $trace[$back]['args'];
        }

        if (is_array($args)) {

            $args = $this->_formatCall($args);
        }

        if (isset($trace[$back]['class'])) {

            $call .= $trace[$back]['class'];
        }

        if (isset($trace[$back]['type'])) {

            $call .= $trace[$back]['type'];
        }

        // Some rare cases have no file and line details
        if (empty($trace[$back]['file'])) {

            $trace[$back]['file'] = '';
            $trace[$back]['line'] = '';
        }

        $file = $this->_formatFile($trace[$back]['file']);

        // Build array with details
        $call = $call . $trace[$back]['function'] . '(' . $args . ')';

        $out = ['step' => $back,
                'file' => $file,
                'line' => $trace[$back]['line'],
                'call' => $call];

        return $out;
    }

    /**
     * Format filename
     *
     * @param string $filename Filename
     *
     * @return string
     **/

    private function _formatFile($filename)
    {
        // Shorten and style file names
        $filename = str_replace('\\', '/', $filename);

        $filepath = substr($filename, 0, $this->_cut);

        if ($filepath == $this->_path) {

            $filename = substr($filename, $this->_cut);
        }

        return $filename;
    }
}
