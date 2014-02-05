<?php

/**
 * Provides mail functionality using the php mail function
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
 * Provides mail functionality using the php mail function
 *
 * @category  Core
 * @package   Mail
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_Sendmail extends Base
{
    /**
     * Creates the mail handler object
     *
     * @param array $config Configuration details as an array
     *
     * @return \csphere\core\mail\Driver_Sendmail
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        // Change sendmail setting
        ini_set('sendmail_from', $this->config['from']);
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
        // Run initial preparations
        parent::prepare($subject, $message, $type);

        // Set header data
        $headers = ["MIME-Version: 1.0",
                    "Content-Type: " . $type . "; charset=UTF-8",
                    "Content-Transfer-Encoding: base64",
                    "X-Mailer: cSphere",
                    "From: " . $this->config['from']];

        $this->headers = array_merge($this->headers, $headers);

        // Create encoded subject and content strings
        $this->encode();

        return true;
    }

    /**
     * Sends the prepared content to a given email
     *
     * @param string  $email Email target
     * @param boolean $clear Defaults to true which keeps mail data
     *
     * @return boolean
     **/

    public function send($email, $clear = true)
    {
        // Send mail
        $headers = implode($this->config['eol'], $this->headers);

        $send = mail(
            $email, $this->content['subject_b64'],
            $this->content['message_b64'], $headers
        );

        // Log mail and handle clear status
        $this->log($email, $send);

        $this->clear($clear);

        return $send;
    }
}