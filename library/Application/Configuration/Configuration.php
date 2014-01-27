<?php
namespace Application\Configuration;

use Application\FileManager\FileManager;
use Application\Exception\ExceptionRuntime;

trait Configuration
{
    /**
     * Load Configuration File
     * 
     * @param string $entity 
     * @return stdClass object
     */
    public function config($entity = 'Default')
    {
        // try-catch
        try {
            // Build file path
            $_path = __DIR__ . '/Resources/' . (string)$entity . '.json';

            // Wrong configuration file
            if(file_exists($_path) === false) {
                throw new ExceptionRuntime(sprintf('Undefined configuration file "%s"', $entity));
            }

            // Decode JSON as object
            $json_decode = json_decode((new FileManager)->getContentsFromFile($_path));

            // Decode error
            if($json_decode == null) {
                throw new ExceptionRuntime('Something goes wrong with configuration file.');
            }
            
            return $json_decode;
        } catch(ExceptionRuntime $exception) {
            die($exception->getMessage());
        }
    }
}
