<?php

/**
 * Provides logging functionality
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
 * Provides logging functionality
 *
 * @category  Core
 * @package   Logs
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Base extends \csphere\core\service\Drivers
{
    /**
     * Stores the logging content
     **/
    protected $channels = [];

    /**
     * Mails the log content
     *
     * @param string $component Name of the core component
     * @param string $content   Content to log in this case
     *
     * @return void
     **/

    private function _mail($component, $content)
    {
        $mail = $this->loader->load('mail');

        $mail->prepare('Log entry: ' . $component, $content);

        // Only send mail when there is a mail_to set
        if (!empty($this->config['mail_to'])) {

            $mail->send($this->config['mail_to']);
        }
    }

    /**
     * Returns a formatted array with statistics
     *
     * @return array
     **/

    public function info()
    {
        return $this->channels;
    }

    /**
     * Logs the content for the component of choice
     *
     * @param string  $component Name of the core component
     * @param string  $content   Content to log in this case
     * @param boolean $store     Defaults to true which enables log files
     * @param string  $append    Append a string only for log files
     *
     * @return void
     **/

    public function log($component, $content, $store = true, $append = '')
    {
        // Create array element for component if not done so far
        if (empty($this->channels[$component])) {

            $this->channels[$component] = [];
        }

        // Add entry to live log
        $this->channels[$component][] = $content;

        // Store entry if enabled and true
        if ($store == true && isset($this->config['save'][$component])) {

            $this->store($component, $content . $append);
        }

        // Mail entry if enabled
        if (isset($this->config['mail'][$component])) {

            $this->_mail($component, $content . $append);
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

    abstract protected function store($component, $content);
}