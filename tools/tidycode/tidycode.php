<?php

/**
 * Automated source code cleanup tool
 *
 * PHP Version 5
 *
 * @category  Tools
 * @package   Tidycode
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

/**
 * Works on a single file
 *
 * @param string $file Filename including path
 *
 * @return boolean
 **/

function tidycodeFile ($file)
{
    // File extensions where the encoding will be converted
    $allowed = array(
        'bat', 'conf', 'config', 'css', 'editorconfig', 'gitattributes',
        'gitignore', 'hdf', 'htaccess', 'htm', 'html', 'ini', 'js', 'md', 'php',
        'properties', 'sh', 'txt', 'xml', 'xsd', 'xsl', 'tpl', 'txt', 'yml'
    );

    // File extensions that are known as forbidden
    $forbidden = array(
        'eot', 'gif', 'ico', 'jpg', 'log', 'otf', 'phar', 'png', 'sqlite',
        'svg', 'svgz', 'tmp', 'ttf', 'woff'
    );

    // Get file data and try to tidy it
    $data = pathinfo($file);

    $changed = false;

    if (empty($data['extension'])) {

        $skipped = "\n" . 'Info: Skipped file due to empty extension'
                 . "\n" . 'File: "' . $file . "\n";

        echo $skipped;

    } elseif (in_array($data['extension'], $allowed)) {

        $content_old = file_get_contents($file);
        $content     = $content_old;

        // Directories starting with '.' are ignored
        if (isset($data['dirname'][6]) && $data['dirname'][6] != '.') {

            // Replace line endings to unix
            $content = str_replace("\r\n", "\n", $content);

            // Replace tabs to four spaces
            $content = str_replace("\t", "    ", $content);

            // Remove whitespace from line endings
            $lines = explode("\n", $content);

            foreach ($lines AS $line => $string) {

                $lines[$line] = rtrim($string);
            }

            $content = implode("\n", $lines);
        }

        // All files should end with one empty newline
        $content = rtrim($content) . "\n";

        // Save updated file content on changes
        $changed = tidycodeSave($file, $content, $content_old);

    } elseif (!in_array($data['extension'], $forbidden)) {

        $unknown = "\n" . 'Error: Extension "' . $data['extension']
                 . '" not known' . "\n" . 'File: ' . $file . "\n";

        echo $unknown;
    }

    return $changed;
}

/**
 * Saves updated content to files
 *
 * @param string $file        File
 * @param string $content     Content
 * @param string $content_old Content before changes
 *
 * @return boolean
 **/

function tidycodeSave ($file, $content, $content_old)
{
    // Check if file has been changed
    $result   = false;
    $file_low = strtolower($file);

    if ($content !== $content_old || $file_low !== $file) {

        unlink($file);

        $filehandler = fopen($file_low, 'w');
        fwrite($filehandler, $content);
        fclose($filehandler);

        $result = true;
    }

    return $result;
}

/**
 * Changes the encoding of a file to unicode
 *
 * @param string $dir Directory
 *
 * @return string
 **/

function tidycodeDir ($dir)
{
    // File names and directories to skip
    $ignore = array(
        '.', '..', '.git', '.idea', '.sonar', 'DS_Store', 'images', 'tmp'
    );

    static $count_dirs    = 0;
    static $count_files   = 0;
    static $changed       = '';
    static $changed_count = 0;

    // Switch to current working directory
    $targetdir = $dir . '/';

    $count_dirs++;

    $dirlist = scandir($targetdir);

    foreach ($dirlist AS $filename) {

        if (!in_array($filename, $ignore)) {

            $nextcheck = $targetdir . $filename;

            if (is_dir($nextcheck)) {

                tidycodeDir($nextcheck);

            } else {

                $count_files++;

                $check = tidycodeFile($nextcheck);

                if ($check == true) {

                    $changed .= "\n" . 'Changed: "' . $nextcheck . '"';

                    $changed_count++;

                    echo '|';
                }
            }
        }
    }

    echo '.';



    $stats = "\n" . $changed . "\n\n" . 'Tidycode scanned ' . $count_dirs
           . ' directories and changed ' . $changed_count . ' of ' . $count_files
           . ' files' . "\n";

    return $stats;
}

// The directory to start from
$dir = '../..';

// Running this could take a while
echo tidycodeDir($dir);
