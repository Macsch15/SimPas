<?php
namespace Application\FileManager;

use Application\Application;
use Application\Exception\ExceptionRuntime;
use Application\Exception\ExceptionInvalidArgument;
use DirectoryIterator;

class FileManager
{
    /**
     * Get url contents
     * 
     * @param string $url
     * @param array $http_attributes
     * @param int $timeout
     * @param bool $headers
     * @throws Application\Exception\ExceptionRuntime
     * @throws Application\Exception\ExceptionInvalidArgument
     * @return string|bool
     */
    public function getContentsFromUrl($url, array $http_attributes = [], 
        $timeout = 60, $headers = false
    ) {
        if (extension_loaded('curl') === false) {
            throw new ExceptionRuntime('cURL extension must be installed');
        }

        // Check URL
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new ExceptionInvalidArgument(sprintf('++%s+-+ is not URL', $url));
        }

        // Create cURL resource
        $handle = curl_init();

        // Get content
        curl_setopt($handle, CURLOPT_URL, $url);
        // Headers
        curl_setopt($handle, CURLOPT_HEADER, $headers);
        // Return transfer
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        // Set timeout
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $timeout);
        // HTTP attributes
        curl_setopt($handle, CURLOPT_POSTFIELDS, $http_attributes);
        
        // Execute!
        $exec = curl_exec($handle);

        // Close session
        curl_close($handle);

        return $exec;
    }

    /**
     * Get contents from file
     * 
     * @param string $file
     * @return string|bool
     */
    public function getContentsFromFile($file)
    {
        // Get data
        $data = @file_get_contents($file);

        // Fail?
        if($data === false) {
            return false;
        }

        return $data;
    }
}
