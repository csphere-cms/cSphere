<?php

/**
 * Looks for request information
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   HTTP
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\http;

/**
 * Looks for request information
 *
 * @category  Core
 * @package   HTTP
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Request
{
    /**
     * Get request data and store it
     **/
    private static $_request = [];

    /**
     * Check request content and prepare data for later usage
     *
     * @param array $server Content of predefined server data
     *
     * @return array
     **/

    private static function _meta(array $server)
    {
        $request = [];

        // Get dirname and protocol
        $request['dirname']  = self::_dirname($server['SCRIPT_NAME']);
        $request['protocol'] = self::_protocol($server);

        // Get current dns and port
        $request['dns']  = $server['HTTP_HOST'];
        $request['port'] = '';

        $port_pos = strpos($request['dns'], ':');

        if ($port_pos !== false) {

            $request['dns']  = substr($request['dns'], 0, $port_pos);
            $request['port'] = strstr($request['dns'], ':');
        }

        return $request;
    }

    /**
     * Determine request dirname and query string
     *
     * @param string $script Script name of URI
     *
     * @return string
     **/

    private static function _dirname($script)
    {
        $script = rawurlencode($script);
        $script = str_replace('%2F', '/', $script);

        // Parse dummy URL and get path
        $url           = 'http://csphere.eu' . '/' . ltrim($script, '/');
        $parts         = parse_url($url);
        $parts['path'] = str_replace('/index.php', '', $parts['path']);
        $parts['path'] = rtrim($parts['path'], '/') . '/';

        return $parts['path'];
    }

    /**
     * Determine request protocol
     *
     * @param array $server Content of predefined server data
     *
     * @return string
     **/

    private static function _protocol(array $server)
    {
        $protocol = 'http';

        // Protocol could be forwarded by one webserver
        if (isset($server['HTTPS'])
            && $server['HTTPS'] == 'on'
            || isset($server['HTTP_X_FORWARDED_PROTO'])
            && $server['HTTP_X_FORWARDED_PROTO'] == 'https'
        ) {
            $protocol .= 's';
        }

        return $protocol;
    }

    /**
     * Splits the request content
     *
     * @param array $server Content of predefined server data
     *
     * @return array
     **/

    private static function _data(array $server)
    {
        $run   = 0;
        $map   = $server['REQUEST_URI'];
        $split = explode('?', $map, 2);

        // Check if request type is pretty_url based
        if (isset($split[1])) {

            $map = str_replace(['&', '='], '/', $split[1]);

        } else {

            $run    = 2;
            $length = strlen(self::$_request['dirname']);
            $map    = substr($map, $length);
            $map    = str_replace('index.php', '', $map);
        }

        // Creates a key value array out of the request map
        $parts = explode('/', $map);

        $data = self::_dataParts($run, $parts);

        // Set plugin and action for pretty_url
        if ($run == 2) {

            $data['plugin'] = $parts[0];
            $data['action'] = isset($parts[1]) ? $parts[1] : '';
        }

        return $data;
    }

    /**
     * Generate an array of all data parts
     *
     * @param integer $start First part that should be used
     * @param array   $parts Parameters as an array
     *
     * @return array
     **/

    private static function _dataParts($start, array $parts)
    {
        $data = [];

        $parts_count = count($parts);

        // Additional key value pairs
        for ($i = $start; $i < $parts_count; $i+=2) {

            if (!empty($parts[$i])) {

                $data[$parts[$i]] = isset($parts[($i+1)]) ?
                    $parts[($i+1)] : null;
            }
        }

        return $data;
    }

    /**
     * Delivers the request content
     *
     * @param string $key Get a specific array key, e.g. dirname
     *
     * @return mixed
     **/

    public static function get($key = '')
    {
        // Check if request data is already prepared
        if (self::$_request == []) {

            // Fetch server data
            $server = \csphere\core\http\Input::getAll('server');

            // Get request information and optimize its content for later usage
            self::$_request = self::_meta($server);

            // Get request data
            self::$_request['data'] = self::_data($server);
        }

        // Check if a key is given
        if (empty($key)) {

            return self::$_request;

        } elseif (isset(self::$_request[$key])) {

            return self::$_request[$key];

        } else {

            return null;
        }
    }
}
