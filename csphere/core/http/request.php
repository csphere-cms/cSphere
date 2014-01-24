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
    private static $_request = array();

    /**
     * Check request content and prepare data for later usage
     *
     * @param array $server Content of predefined server data
     *
     * @return array
     **/

    private static function _meta(array $server)
    {
        $request = pathinfo($server['SCRIPT_NAME']);

        // All slashes might go one way and dirname may end with a slash
        $request['dirname'] = str_replace('\\', '/', $request['dirname']);
        $request['dirname'] = rtrim($request['dirname'], '/') . '/';

        $request['protocol'] = self::_protocol($server);

        // Get current dns and port
        $request['dns'] = $server['HTTP_HOST'];
        $request['port'] = '';

        $port_pos = strpos($request['dns'], ':');

        if ($port_pos !== false) {

            $request['dns'] = substr($request['dns'], 0, $port_pos);
            $request['port'] = strstr($request['dns'], ':');
        }

        // Add request method
        $request['method'] = '';

        if (isset($server['REQUEST_METHOD'])) {

            $request['method'] = $server['REQUEST_METHOD'];
        }

        return $request;
    }

    /**
     * Determine request protocol
     *
     * @param array $server Content of predefined server data
     *
     * @return array
     **/

    private static function _protocol(array $server)
    {
        $protocol = 'http';

        // Protocol could be forwarded by one webserver
        if (isset($server['HTTPS'])
            AND $server['HTTPS'] == 'on'
            OR isset($server['HTTP_X_FORWARDED_PROTO'])
            AND $server['HTTP_X_FORWARDED_PROTO'] == 'https'
        ) {
            $protocol .= 's';
        }

        return $protocol;
    }

    /**
     * Splits the request content
     *
     * @param array  $server  Content of predefined server data
     * @param string $dirname Name of directory
     *
     * @return array
     **/

    private static function _data(array $server, $dirname)
    {
        // The uri contains important information, but the dirname should be cut
        $map = substr($server['REQUEST_URI'], strlen($dirname));

        // Test if url uses pretty link style or needs some changes
        $qmark = strpos($map, '?');
        $slash = strpos($map, '/');
        $run   = 2;

        if ($qmark !== false AND ($slash === false OR $qmark < $slash)) {

            $run = 1;
            $map = substr($map, $qmark);
            $map = str_replace(array('?plugin='), '', $map);
            $map = str_replace(array('&','='), '/', $map);
        }

        // Creates a key value array out of the request map
        $parts = explode('/', $map);

        $data = self::_dataParts($run, $parts);

        // Plugin is always in front
        $data['plugin'] = $parts[0];

        // Action is second with pretty urls
        if ($run == 2) {

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
        $data = array();

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
        if (self::$_request == array()) {

            // Fetch server data
            $server = \csphere\core\http\Input::getAll('server');

            // Get request information and optimize its content for later usage
            self::$_request = self::_meta($server);

            // Get request data
            self::$_request['data'] = self::_data(
                $server, self::$_request['dirname']
            );
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