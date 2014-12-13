<?php
namespace Application\Configuration;

use Application\FileManager\FileManager;
use Application\Exception\AssetNotFound;
use Application\Exception\JsonException;

trait Configuration
{
    /**
     * Load Configuration File
     * 
     * @param string $entity
     * @param bool $as_array
     * @return object|array
     * @throws Application\Exception\JsonException
     * @throws Application\Exception\AssetNotFound
     */
    public function config($entity = 'Default', $as_array = false)
    {
        // try-catch
        try {
            // Build file path
            $_path = __DIR__ . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . $entity . '.json';

            // Wrong configuration file
            if (file_exists($_path) === false) {
                throw new AssetNotFound(sprintf('Undefined configuration file "%s"', $entity));
            }

            // Decode JSON as object or array
            $json_decode = json_decode((new FileManager)->getContentsFromFile($_path), ($as_array === true ?: false));

            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    $error_message = false;
                    break;
                case JSON_ERROR_DEPTH:
                    $error_message = 'Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $error_message = 'Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $error_message = 'Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $error_message = 'Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $error_message = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $error_message = 'Unknown error';
                    break;
            }

            if($error_message !== false) {
                throw new JsonException('JSON Error: ' . $error_message . ' in ' . $entity . '.json');
            }

            return $json_decode;
        } catch(JsonException $exception) {
            // Set headers
            header('HTTP/1.1 502 Bad Gateway', true, 502);

            die($exception->getMessage());
        } catch(AssetNotFound $exception) {
            // Set headers
            header('HTTP/1.1 502 Bad Gateway', true, 502);

            die($exception->getMessage());
        }
    }
}
