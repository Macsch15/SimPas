<?php
namespace Application\FileManager;

use Application\Exception\ExceptionInvalidArgument;
use Application\Exception\ExceptionRuntime;

class FileManager
{
    /**
     * Get url contents
     * 
     * @param string $url
     * @param array $http_attributes
     * @param int $timeout
     * @param bool $headers
     * @return string|bool
     * @throws ExceptionInvalidArgument
     * @throws ExceptionRuntime
     */
    public function getContentsFromUrl($url, array $http_attributes = [], 
        $timeout = 60, $headers = false
    ) {
        if (extension_loaded('curl') === false) {
            throw new ExceptionRuntime('cURL extension must be installed');
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new ExceptionInvalidArgument(sprintf('++%s+-+ is not URL', $url));
        }

        $handle = curl_init();

        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $http_attributes);
        
        $exec = curl_exec($handle);

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
        $data = @file_get_contents($file);

        if($data === false) {
            return false;
        }

        return $data;
    }
}
