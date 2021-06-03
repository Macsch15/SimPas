<?php

namespace SimPas\Pastebin;

use SimPas\Application;
use SimPas\Configuration\Configuration;

class SendPaste
{
    use Configuration;

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
        $this->data_source = $application->dbConnectionAccessor();
    }

    /**
     * Send paste.
     *
     * @param array $container
     *
     * @return void
     */
    public function send(array $container)
    {
        $query = $this->data_source
            ->get()
            ->prepare('INSERT INTO ' . $this->config('database')['prefix'] . 'pastes (
            unique_id,
            time,
            size,
            length,
            syntax,
            content,
            ip_address,
            raw_content,
            title,
            author,
            start_from_line,
            visibility,
            author_website,
            short_url,
            expire
        ) VALUES (
            :unique_id,
            :time,
            :size,
            :length,
            :syntax,
            :content,
            :ip_address,
            :raw_content,
            :title,
            :author,
            :start_from_line,
            :visibility,
            :author_website,
            :short_url,
            :expire
        );');

        $query->bindValue(':unique_id', $container['paste_id'], constant('PDO::PARAM_INT'));
        $query->bindValue(':time', $container['paste_time'], constant('PDO::PARAM_INT'));
        $query->bindValue(':size', $container['paste_size'], constant('PDO::PARAM_INT'));
        $query->bindValue(':length', $container['paste_length'], constant('PDO::PARAM_INT'));
        $query->bindValue(':syntax', $container['paste_syntax']);
        $query->bindValue(':content', $container['paste_content']);
        $query->bindValue(':ip_address', $container['paste_client_ip']);
        $query->bindValue(':raw_content', $container['paste_raw_content']);
        $query->bindValue(':title', $this->normalizeTitleAndAuthorField($container['paste_title']));
        $query->bindValue(':author', $this->normalizeTitleAndAuthorField($container['paste_author']));
        $query->bindValue(':start_from_line', $container['paste_start_from_line'], constant('PDO::PARAM_INT'));
        $query->bindValue(':visibility', $container['paste_visibility']);
        $query->bindValue(':author_website', $container['paste_author_website']);
        $query->bindValue(':short_url', $container['paste_short_url']);
        $query->bindValue(':expire', $container['paste_expire']);

        $query->execute();
    }

    /**
     * Normalize paste title and author.
     *
     * @param string $string
     *
     * @return string
     */
    private function normalizeTitleAndAuthorField($string)
    {
        if (strlen($string) > 50) {
            $string = substr($string, 0, 50);
        }

        return $string;
    }

    /**
     * Generate ID.
     *
     * @return int
     */
    public function generateId()
    {
        $id = time();
        $id = substr($id, 2);
        $id = mt_rand(0, 15) . $id;

        $uniq = (int)uniqid();
        $uniq = (isset($uniq[0]) && isset($uniq[1]) ? $uniq[0] . $uniq[1] : 0);

        return (int)$id . $uniq;
    }
}
