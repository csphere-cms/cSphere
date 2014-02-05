<?php

/**
 * Provides mail functionality using a remote smtp connection
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
 * Provides mail functionality using a remote smtp connection
 *
 * @category  Core
 * @package   Mail
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_SMTP extends Base
{
    /**
     * Stores the server address
     **/
     private $_server = '';

    /**
     * Creates the mail handler object
     *
     * @param array $config Configuration details as an array
     *
     * @return \csphere\core\mail\Driver_SMTP
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        // Get server address of this machine
        $this->_server = \csphere\core\http\Input::get('server', 'SERVER_ADDR');
    }

    /**
     * Prepares a command list for later usage
     *
     * @param string $email Email target
     *
     * @return array
     **/

    private function _commands($email)
    {
        // Prepare header data
        $headers   = [];
        $headers[] = 'To: ' . $email;
        $headers[] = 'Subject: ' . $this->content['subject_b64'];

        $headers = implode($this->config['eol'], $this->headers);

        // Combine content parts
        $data = $headers . $this->config['eol']
              . $this->content['message_b64'] . $this->config['eol'] . '.';

        // Create command list
        $commands = ['helo' => 'HELO ' . $this->_server,
                     'login' => 'AUTH LOGIN',
                     'user' => base64_encode($this->config['username']),
                     'pw' => base64_encode($this->config['password']),
                     'from' => 'MAIL FROM:' . $this->config['from'],
                     'to' => 'RCPT TO:' . $email,
                     'data' => 'DATA',
                     'response' => $data,
                     'quit' => 'QUIT'];

        return $commands;
    }

    /**
     * Execute the commands on smtp server
     *
     * @param array $commands Commands to work with
     *
     * @return boolean
     **/

    private function _remote(array $commands)
    {
        $result = false;

        $log = [];

        // Open connection to smtp server
        $remote = fsockopen($this->config['host'], (int)$this->config['port']);

        // On success proceed
        if (is_resource($remote)) {

            // Set timeout
            stream_set_timeout($remote, (int)$this->config['timeout']);

            foreach ($commands AS $com_name => $com_exec) {

                // Send command and get answer
                fwrite($remote, $com_exec . $this->config['eol']);

                $read = fread($remote, 2048);

                // Store communication in log
                $log[] = $com_name . ': ' . $read;

                // Stop on bad status code
                $code = (int) substr($read, 0, 3);

                if ($code >= 400) {

                    fclose($remote);

                    $this->_errorlog($code, (array)$log);

                    return false;
                }
            }

            // Tidy up and store success
            fclose($remote);

            $result = true;

        }

        return $result;
    }

    /**
     * Handle SMTP Server communication errors
     *
     * @param integer $code Status code
     * @param array   $log  Log as an array
     *
     * @throws \Exception
     *
     * @return void
     **/

    private function _errorlog($code, array $log)
    {
        $error = empty($code) ? 'Unknown' : 'Bad status code - ' . $code;

        // Append server communication
        $error .= "\n" . 'Communication:' . "\n" . implode("\n", $log);

        // Throw exception
        throw new \Exception($error);
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
        $headers = ['MIME-Version: 1.0',
                    'Content-Type: ' . $type . '; charset=UTF-8',
                    'Content-Transfer-Encoding: base64',
                    'X-Mailer: cSphere',
                    'From: ' . $this->config['from']];

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
        $commands = $this->_commands($email);

        $send = $this->_remote($commands);

        // Log mail and handle clear status
        $this->log($email, $send);

        $this->clear($clear);

        return $send;
    }
}