<?php
namespace Application\Pastebin;

use Application\Application;
use Application\Configuration\Configuration;
use Application\HttpRequest\HttpRequest;
use Application\Pastebin\Helpers\Strings;
use Application\Security\QuestionsAndAnswers\QuestionsAndAnswers;
use Application\View\View;

class Controller extends View
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
     * @throws \Application\Exception\ExceptionRuntime
     */
    public function __construct(Application $application)
    {
        parent::__construct($application);

        $this->application = $application;
        $this->data_source = $this->application->dbConnectionAccessor();
    }

    /**
     * Index page
     *
     * @return void
     * @throws \Application\Exception\ExceptionRuntime
     */
    public function indexAction()
    {
        $this->render([
            'geshi_languages' => (new SyntaxHighlighter)->languagesToArray(),
            'paste_id' => (new SendPaste($this->application))->generateId(),
            'antispam' => new QuestionsAndAnswers()
        ]);

        return $this->{'IndexBlock'};
    }

    /**
     * Read
     *
     * @param array $request
     * @return void
     * @throws \Application\Exception\ExceptionRuntime
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function readAction(array $request)
    {
        if (HttpRequest::post('post_poked') === false && (new ReadPaste($this->application))->pasteExists($request['id']) === false) {
            return $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'), true);
        }

        if((new PasteExpire($this->application))->isExpired($request['id']) === true) {
            return $this->sendFriendlyClientError(_('Requested paste has expired.'), true);
        }

        if (HttpRequest::post('post_poked') !== false && $this->config()['antispam_enabled'] === true &&
            (new QuestionsAndAnswers())->validate(HttpRequest::post('post_antispam_question'), 
                HttpRequest::post('post_antispam_answer')) === false
        ) {
            return $this->sendFriendlyClientError(_('Wrong anti-spam answer. Refresh page and try again.'));
        } 

        if($this->clientIpIsBanned() === true && HttpRequest::post('post_poked') !== false) {
            return $this->sendFriendlyClientError(_('You have no permissions to send paste.'));
        }

        if($this->sizeAndLengthValidator(HttpRequest::post('post_paste_content')) === false) {
            return $this->sendFriendlyClientError(_('Size or length in this paste is more than allowed.'));
        }

        if (HttpRequest::isEmptyField([
            HttpRequest::post('post_paste_content'),
            HttpRequest::post('post_paste_title', true),
            HttpRequest::post('post_paste_author', true)
          ], HttpRequest::post('post_paste_content')) && 
            (new ReadPaste($this->application))->pasteExists($request['id']) === false
        ) {
            return $this->sendFriendlyClientError(_('Some field there are empty or contains prohibited characters (e.g only spaces).'));
        }

        if($this->isFloodedClient() === true) {
            return $this->sendFriendlyClientError(
                sprintf(_('Anty-flood is enabled. Please wait at least %d seconds before attempting to send paste again.'), 
                    $this->config()['antyflood_delay_in_seconds']));
        }

        if((new ReadPaste($this->application))->pasteExists($request['id']) === false) {
            (new SendPaste($this->application))->send($this->toSendDataContainer($request));
        }

        (new Hits($this->application))->update($request['id']);
        
        $this->render([
            'paste' => (new ReadPaste($this->application))->read($request['id'])
        ]);

        return $this->{'ReadPaste'};
    }

    /**
     * Paste data to send container
     *
     * @param array $request
     * @return array
     * @throws \Application\Exception\ExceptionRuntime
     */
    private function toSendDataContainer(array $request)
    {
        return [
            'paste_id' => $request['id'],
            'paste_time' => time(),
            'paste_size' => Strings::stringToBytes(HttpRequest::post('post_paste_content')),
            'paste_length' => strlen(HttpRequest::post('post_paste_content')),
            'paste_syntax' => (new SyntaxHighlighter)->validateLanguage(HttpRequest::post('post_syntax_highlight_language')),
            'paste_content' => (new SyntaxHighlighter)->parseCode(HttpRequest::post('post_paste_content'),
                strtolower(HttpRequest::post('post_syntax_highlight_language')), $this->startListCountingFromLine(),
                    HttpRequest::post('post_checkbox_line_numbering')),
            'paste_client_ip' => HttpRequest::getClientIpAddress(),
            'paste_raw_content' => HttpRequest::post('post_paste_content'),
            'paste_title' => HttpRequest::post('post_paste_title', true),
            'paste_author' => HttpRequest::post('post_paste_author', true),
            'paste_start_from_line' => $this->startListCountingFromLine(),
            'paste_visibility' => $this->pasteVisibility(),
            'paste_author_website' => $this->authorWebsite(),
            'paste_short_url' => $this->saveShortUrl($request['id']),
            'paste_expire' => (new PasteExpire($this->application))->validateExpireTimeFromClient(HttpRequest::post('post_paste_expire'))
        ];
    }

    /**
     * Anty-flood
     *  
     * @return bool
     */
    private function isFloodedClient()
    {
        if ($this->config()['antyflood_enabled'] === false || HttpRequest::post('post_poked') === false) {
            return false;
        }

        $query = $this->data_source
        ->get()
        ->prepare('SELECT ip_address FROM ' . $this->config('database')['prefix'] . 'pastes WHERE ip_address = :ip_address');

        $query->bindValue(':ip_address', HttpRequest::getClientIpAddress());
        $query->execute();

        $rows = $query->fetchAll();

        if (!is_array($rows) || !count($rows)) {
            return false;
        }

        $query = $this->data_source
        ->get()
        ->prepare('SELECT ip_address, time FROM ' . $this->config('database')['prefix'] . 'pastes WHERE ip_address = :ip_address 
            AND time >= :time');

        $query->bindValue(':ip_address', HttpRequest::getClientIpAddress());
        $query->bindValue(':time', time() - $this->config()['antyflood_delay_in_seconds']);
        $query->execute();

        $rows = $query->fetchAll();

        if (!is_array($rows) || !count($rows)) {
            return false;
        }

        return true;
    }

    /**
     * Paste visibility
     *  
     * @return string
     */
    private function pasteVisibility()
    {
        switch (HttpRequest::post('post_paste_visibility')) {
            case 'public':
                return 'public';
                break;
            case 'private':
            default:
                return 'private';
                break;
        }
    }

    /**
     * Author website
     * 
     * @return string|null
     */
    private function authorWebsite()
    {
        if (HttpRequest::post('post_paste_author_website', 'html') !== false
            && filter_var(HttpRequest::post('post_paste_author_website', 'html'), FILTER_VALIDATE_URL) !== false
            && $this->config()['author_website_enabled'] === true
        ) {
            return HttpRequest::post('post_paste_author_website', 'html');
        }

        return null;
    }

    /**
     * Banned IP's
     *  
     * @return bool
     */
    private function clientIpIsBanned()
    {
        if (is_array($this->config()['banned_ip']) === false || !count($this->config()['banned_ip'])) {
            return false;
        }

        foreach($this->config()['banned_ip'] as $banned_ip) {
            $banned_ip = str_replace(['*', '.'], ['(\d+)', '\.'], $banned_ip);

            if (preg_match('/' . $banned_ip . '/', HttpRequest::getClientIpAddress())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Raw mode page
     *
     * @param array $request
     * @return void
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     * @throws \Application\Exception\ExceptionRuntime
     */
    public function rawModeAction(array $request)
    {
        if (HttpRequest::post('post_poked') === false && (new ReadPaste($this->application))->pasteExists($request['id']) === false) {
            return $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'));
        }

        header('Content-type: text/plain; charset=UTF-8');

        $this->render([
            'raw_content' => (new ReadPaste($this->application))->read($request['id'])['raw_content']
        ]);

        return $this->{'RawMode'};
    }

    /**
     * Embed
     *
     * @param array $request
     * @return void|bool
     * @throws \Application\Exception\ExceptionRuntime
     */
    public function embedAction(array $request)
    {
        if (HttpRequest::post('post_poked') === false && (new ReadPaste($this->application))->pasteExists($request['id']) === false) {
            return false;
        }
        
        $this->render([
            'paste' => (new ReadPaste($this->application))->read($request['id']),
        ]);

        return $this->{'Embed'};        
    }

    /**
     * JSON API
     *
     * @param array $request
     * @return void
     * @throws \Application\Exception\ExceptionRuntime
     */
    public function jsonApiAction(array $request)
    {
        if (HttpRequest::post('post_poked') === false && (new ReadPaste($this->application))->pasteExists($request['id']) === false) {
            $json_response['error'] = 'Requested paste doesn\'t exists.';
        }

        header('Content-type: text/plain; charset=UTF-8');

        if (isset($json_response['error']) === false) {
            $json_response = [
                'paste_id' => (new ReadPaste($this->application))->read($request['id'])['unique_id'],
                'submitted' => (new ReadPaste($this->application))->read($request['id'])['time'],
                'size' => (new ReadPaste($this->application))->read($request['id'])['size'],
                'length' => (new ReadPaste($this->application))->read($request['id'])['length'],
                'syntax' => (new ReadPaste($this->application))->read($request['id'])['syntax'],
                'parsed_code' => (new ReadPaste($this->application))->read($request['id'])['content'],
                'not_parsed_code' => (new ReadPaste($this->application))->read($request['id'])['raw_content']
            ];

            if((new ReadPaste($this->application))->read($request['id'])['title'] != null) {
                $json_response['title'] = (new ReadPaste($this->application))->read($request['id'])['title'];
            }

            if((new ReadPaste($this->application))->read($request['id'])['author'] != null) {
                $json_response['author'] = (new ReadPaste($this->application))->read($request['id'])['author'];
            }
        }

        $this->render([
            'json' => json_encode($json_response)
        ]);

        return $this->{'JsonApi'};
    }

    /**
     * Start from line
     * 
     * @return int
     */
    private function startListCountingFromLine()
    {
        $start_from_line = 1;

        if (HttpRequest::post('post_start_from_line')) {
            if(!preg_match('/\d+/', HttpRequest::post('post_start_from_line'))) {
                $start_from_line = 1;
            } else {
                $start_from_line = (int)HttpRequest::post('post_start_from_line');
            }
        }

        return $start_from_line;
    }

    /**
     * Shorten URL
     *
     * @param int $paste_id
     * @return array
     * @throws \Application\Exception\ExceptionInvalidArgument
     * @throws \Application\Exception\ExceptionRuntime
     */
    private function saveShortUrl($paste_id)
    {
        if (filter_var(htmlspecialchars((string)(new ShortenUrlApi())->shorten($this->application->buildUrl('paste/' . $paste_id))), FILTER_VALIDATE_URL) === false
            || $this->config()['short_url'] === false
        ) {
            return null;
        }

        return (new ShortenUrlApi())->shorten(($this->application->buildUrl('paste/' . $paste_id)));
    }

    /**
     * Size and length of paste validator
     * 
     * @param string $content
     * @return bool
     */
    private function sizeAndLengthValidator($content)
    {
        if (strlen($content) > $this->config()['max_chars']) {
            return false;
        }

        if (ceil(Strings::stringToBytes($content) / 1024) > $this->config()['max_size_in_kb']) {
            return false;
        }

        return true;
    }

    /**
     * Download action
     *
     * @param array $request
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     * @throws \Application\Exception\ExceptionRuntime
     */
    public function downloadAction(array $request)
    {
        if (HttpRequest::post('post_poked') === false && (new ReadPaste($this->application))->pasteExists($request['id']) === false) {
            return $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'));
        }

        header('Content-type: text/plain');
        header('Content-Disposition: attachment; filename="' . $request['id'] . '.txt"');

        echo (new ReadPaste($this->application))->read($request['id'])['raw_content'];
    }
}
