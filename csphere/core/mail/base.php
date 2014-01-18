<?php

/**
 * Provides mail functionality
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Mail
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\mail;

/**
 * Provides mail functionality
 *
 * @category  Core
 * @package   Mail
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Base extends \csphere\core\service\Drivers
{
    /**
     * Stores the mail headers
     **/
    protected $headers = array();

    /**
     * Stores the mail subject and message for all use cases
     **/
    protected $content = array();

    /**
     * Stores the logger object
     **/
    protected $logger = null;

    /**
     * Creates the mail handler object
     *
     * @param array $config Configuration details as an array
     *
     * @return \csphere\core\mail\Base
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        // Set end of line setting
        $this->config['eol'] = PHP_EOL;

        if ($this->config['newline'] == 'linux') {

            $this->config['eol'] = "\n";
        } elseif ($this->config['newline'] == 'windows') {

            $this->config['eol'] = "\r\n";
        }
    }

    /**
     * Clears all prepared mail data
     *
     * @param boolean $sure Really clear all mail data
     *
     * @return boolean
     **/

    public function clear($sure = true)
    {
        if ($sure == true) {

            // Clear headers and content
            $this->headers = array();
            $this->content = array();
        }

        return $sure;
    }

    /**
     * Encode mail subject and content with base64
     *
     * @return boolean
     **/

    protected function encode()
    {
        // Encode subject and message
        $subject = base64_encode($this->content['subject_raw']);
        $subject = '=?UTF-8?B?' . $subject . '?=';

        $message = base64_encode($this->content['message_raw']);
        $message = chunk_split($message, 70, $this->config['eol']);

        $this->content['subject_b64'] = $subject;
        $this->content['message_b64'] = $message;

        return true;
    }

    /**
     * Prepares a mail by setting its content
     *
     * @param string $subject Subject to use in email
     * @param string $message Message to use in email
     * @param string $type    Defaults to text/plain
     *
     * @return boolean
     **/

    public function prepare($subject, $message, $type = 'text/plain')
    {
        // Clear earlier data
        $this->clear();

        // Store pure subject for log usage
        $subject = html_entity_decode($subject, ENT_NOQUOTES, 'UTF-8');

        $this->content['subject_log'] = $subject;

        // Append subject prefix set in configuration
        $subject = $this->config['subject'] . ' - ' . $subject;

        $this->content['subject_raw'] = $subject;

        // Store message after decoding entities
        $message = html_entity_decode($message, ENT_NOQUOTES, 'UTF-8');

        $this->content['message_raw'] = $message;

        // Set content type
        $this->content['message_type'] = $type;
    }

    /**
     * Returns a formatted array with configuration and headers
     *
     * @return array
     **/

    public function info()
    {
        $result = $this->config;

        unset($result['smtp_username'], $result['smtp_password']);

        $result['headers'] = implode("\n" . $this->headers);

        return $result;
    }

    /**
     * Sends the prepared content to a given email
     *
     * @param string  $email Email target
     * @param boolean $clear Defaults to true which keeps mail data
     *
     * @return boolean
     **/

    abstract public function send($email, $clear = true);

    /**
     * Logs send mails
     *
     * @param string  $email  Email target
     * @param boolean $status Wether or not the mail was successfully send
     *
     * @return void
     **/

    protected function log($email, $status)
    {
        // Prepare log content
        $store = 'Subject: ' . $this->content['subject_log'] . "\n"
               . 'Target: ' . $email . "\n"
               . 'Status: '  . (int) $status;

        // Get logger if not done yet
        if ($this->logger == null) {

            $this->logger = $this->loader->load('logs');
        }

        $this->logger->log('mail', $store);
    }
}