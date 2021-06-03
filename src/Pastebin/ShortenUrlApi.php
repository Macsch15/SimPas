<?php

namespace SimPas\Pastebin;

use SimPas\FileManager\FileManager;

class ShortenUrlApi
{
    private $bitly_username = 'simpasapplication';
    private $bitly_api_key = 'R_f3518c22e6f64286a06cb7b1306e4702';
    private $file_manager;

    /**
     * ShortenUrlApi constructor.
     */
    public function __construct()
    {
        $this->file_manager = new FileManager();
    }

    /**
     * @param $long_url
     * @return mixed|null
     * @throws \SimPas\Exception\ExceptionInvalidArgument
     * @throws \SimPas\Exception\ExceptionRuntime
     */
    public function shorten($long_url)
    {
        $response = $this->file_manager->getContentsFromUrl(sprintf(
            'https://api.bit.ly/shorten?version=2.0.1&longUrl=%s&login=%s&apiKey=%s',
            urlencode($long_url),
            $this->bitly_username,
            $this->bitly_api_key
        ));

        $response = json_decode($response, true);

        if ($response == null || $response['errorCode'] !== 0) {
            return null;
        }

        $short_url = null;

        foreach ($response['results'] as $site) {
            $short_url = $site['shortUrl'];
        }

        return $short_url;
    }
}
