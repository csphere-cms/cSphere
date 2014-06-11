<?php

/**
 * Provides logging functionality on the filesystem
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
 * Provides logging functionality on the filesystem
 *
 * @category  Core
 * @package   Logs
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_File extends Base
{
    /**
     * Stores the logs directory
     **/
    private $_dir = '';

    /**
     * Creates the logs handler object
     *
     * @param array $config Configuration details as an array
     *
     * @throws \Exception
     *
     * @return \csphere\core\logs\Driver_File
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->_dir = \csphere\core\init\path() . 'csphere/storage/logs/';

        if (!is_writeable($this->_dir)) {

            throw new \Exception('Directory "' . $this->_dir . '" is not writeable');
        }
    }


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
        $filename = $this->_dir . $component . '/' . date('Y-m-d') . '.log';

        $store = "--------\n" . date('H:i:s') . "\n" . $content . "\n";

        $save_log = fopen($filename, 'a');

        // Set stream encoding if possible to avoid converting issues
        if (function_exists('stream_encoding')) {

            stream_encoding($save_log, 'UTF-8');
        }

        fwrite($save_log, $store);
        fclose($save_log);

        // Check if the process owner is the fileowner, otherwise
        // chmod won't work proper and give a warning
        if (get_current_user()==fileowner($filename)) {
            chmod($filename, 0755);
        }

        return true;
    }
}
