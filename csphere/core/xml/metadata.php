<?php

/**
 * Collects the important data from all XML files of one type
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\xml;

/**
 * Collects the important data from all XML files of one type
 *
 * @category  Core
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Metadata
{
    /**
     * Local path
     **/
    protected $path = '';

    /**
     * Service loader object
     **/
    protected $loader = null;

    /**
     * Cache driver object
     **/
    protected $cache = null;

    /**
     * Language shorthandle for translation
     **/
    protected $language = '';

    /**
     * Type of registry
     **/
    protected $driver = '';

    /**
     * Load XML registry
     *
     * @return \csphere\core\xml\Metadata
     **/

    public function __construct()
    {
        $this->path     = \csphere\core\init\path();
        $this->loader   = \csphere\core\service\Locator::get();
        $this->cache    = $this->loader->load('cache');
        $this->language = \csphere\core\translation\Fetch::lang();
    }

    /**
     * Generate registry from XML files
     *
     * @return array
    **/

    protected function generate()
    {
        // Try to load metadata from cache
        $key = 'metadata_' . $this->driver;
        $reg = $this->cache->load($key);

        // If cache loading fails load it and create cache file
        if ($reg == false) {

            // Get a directory listing of all files
            $origin = $this->path . 'csphere/' . $this->driver . 's';
            $files  = \csphere\core\files\File::search($origin);

            // Load XML content into an array
            $xml = $this->loader->load('xml', $this->driver);
            $reg = [];

            foreach ($files AS $name) {

                $reg[$name] = $xml->source($this->driver, $name);
            }

            $this->cache->save($key, $reg);
        }

        return $reg;
    }

    /**
     * Check if an entry exists
     *
     * @param string $short Short name for entry
     *
     * @return boolean
    **/

    public function exists($short)
    {
        // Check if entry is part of registry
        $reg    = $this->generate();
        $result = isset($reg[$short]) ? true : false;

        return $result;
    }

    /**
     * Lists all entries with most important information
     *
     * @return array
    **/

    public function details()
    {
        // Try to load entries from cache
        $key = 'metadata_' . $this->driver . '_details';
        $ent = $this->cache->load($key);

        // If cache loading fails load it and create cache file
        if ($ent == false) {

            // Get registered entries from cache
            $reg = $this->generate();
            $ent = [];

            // Create a list of entries with some important details
            foreach ($reg AS $short => $info) {

                $ent[$short] = ['short'    => $short,
                                'version'  => $info['version'],
                                'pub'      => $info['published'],
                                'name'     => $info['name'],
                                'icon'     => $info['icon']['value'],
                                'icon_url' => $info['icon']['url']];
            }

            $this->cache->save($key, $ent);
        }

        return $ent;
    }
}