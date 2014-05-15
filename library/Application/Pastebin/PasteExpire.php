<?php
namespace Application\Pastebin;

use Application\Application;
use Application\Pastebin\ReadPaste;
use Application\Configuration\Configuration;

class PasteExpire
{
    use Configuration;

    /**
    * Application
    * 
    * @var object
    */
    private $application;
    
    /**
    * DataBase
    * 
    * @var object
    */
    private $data_source;
    
    /**
    * Construct
    * 
    * @param Application $application
    * @return void
    */
    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->data_source = $this->application->dbConnectionAccessor();
    }

    /**
    * Check expiry time
    * 
    * @param int $paste_id
    * @return bool
    */
    public function isExpired($paste_id)
    {
        // Paste exists?
        if((new ReadPaste($this->application))->pasteExists($paste_id) === false) {
            return false;
        }

        // Get the expiry time
        $expiry_time = (new ReadPaste($this->application))->read($paste_id)['expire'];

        // Empty?
        if($expiry_time == null) {
            $expiry_time = 'never';
        }

        // Not expire?
        if($expiry_time === 'never') {
            return false;
        }

        // Test
        if($expiry_time < time()) {
            // Remove expired paste from datasource
            if($this->config()->delete_expired_pastes === true) {
                // Prepare query
                $query = $this->data_source
                ->get()
                ->prepare('DELETE FROM ' . $this->config('Database')->prefix . 'pastes WHERE unique_id = :paste_id');

                // Filter and execute
                $query->bindValue(':paste_id', $paste_id, constant('PDO::PARAM_INT'));
                $query->execute();
            }

            return true;
        }

        return false;
    }

    /**
    * Validate expiry time from client
    * 
    * @param string $post_expiry 
    * @return string|int
    */
    public function validateExpiryTimeFromClient($post_expiry)
    {
        // Empty?
        if($post_expiry == null) {
            $post_expiry = 'never';
        }

        // Test
        switch($post_expiry) {
            case 'never':
            default:
                return 'never';
                break;
            case '1hour':
                // 1 hour
                return time() + 30;
                break;
            case '1week':
                // 1 week
                return time() + 604800;
                break;
            case '1month':
                // 1 month
                return time() + 2629743;
                break;
            case '1year':
                // 1 year
                return time() + 31536000;
                break;
        }

        // Still here?
        return 'never';
    }
}
