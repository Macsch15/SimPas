<?php

namespace SimPas\Pastebin;

use SimPas\Application;
use SimPas\Configuration\Configuration;

class PasteExpire
{
    use Configuration;

    /**
     * Application.
     *
     * @var object
     */
    private $application;

    /**
     * DataBase.
     *
     * @var object
     */
    private $data_source;

    /**
     * Construct.
     *
     * @param Application $application
     *
     * @return void
     * @throws \SimPas\Exception\ExceptionRuntime
     *
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->data_source = $this->application->dbConnectionAccessor();
    }

    /**
     * Check expiry time.
     *
     * @param int $paste_id
     *
     * @return bool
     * @throws \SimPas\Exception\ExceptionRuntime
     *
     */
    public function isExpired($paste_id)
    {
        if ((new ReadPaste($this->application))->pasteExists($paste_id) === false) {
            return false;
        }

        $expire_time = (new ReadPaste($this->application))->read($paste_id)['expire'];

        if ($expire_time == null) {
            $expire_time = 'never';
        }

        if ($expire_time === 'never') {
            return false;
        }

        if ($expire_time < time()) {
            if ($this->config()['delete_expired_pastes'] === true) {
                $query = $this->data_source
                    ->get()
                    ->prepare('DELETE FROM ' . $this->config('database')['prefix'] . 'pastes WHERE unique_id = :paste_id');

                $query->bindValue(':paste_id', $paste_id, constant('PDO::PARAM_INT'));
                $query->execute();
            }

            return true;
        }

        return false;
    }

    /**
     * Validate expiry time from client.
     *
     * @param string $post_expire
     *
     * @return string|int
     */
    public function validateExpireTimeFromClient($post_expire)
    {
        if ($post_expire == null) {
            $post_expire = 'never';
        }

        switch ($post_expire) {
            case 'never':
            default:
                return 'never';
                break;
            case '1hour':
                return time() + 3600;
                break;
            case '1week':
                return time() + 604800;
                break;
            case '1month':
                return time() + 2629743;
                break;
            case '1year':
                return time() + 31536000;
                break;
        }
    }
}
