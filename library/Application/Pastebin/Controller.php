<?php
namespace Application\Pastebin;

use Application\Application;
use Application\View\View;
use Application\Configuration\Configuration;
use Application\Pastebin\SyntaxHighlighter;
use Application\Pastebin\SendPaste;
use Application\Pastebin\ReadPaste;
use Application\HttpRequest\HttpRequest;

class Controller extends View
{
    use Configuration;

    /**
    * Application
    * 
    * @var
    */
    private $application;

    /**
    * DataBase
    * 
    * @var object
    */
    private $data_source;

    /**
    * Paste data from data source
    * 
    * @var array
    */
    private $paste_data;

    /**
    * Construct
    * 
    * @param Application $application
    * @return void
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
    */
    public function indexAction()
    {
        // Template render
        $this->render([
            'geshi_languages' => (new SyntaxHighlighter)->languagesToArray(),
            'paste_id' => (new SendPaste($this->application))->generateId(),
        ]);

        return $this->{'IndexBlock'};
    }

    /**
    * Rules page
    * 
    * @return void
    */
    public function rulesAction()
    {
        return $this->{'Rules'};
    }

    /**
    * Read
    * 
    * @param array $request
    * @return void
    */
    public function readAction(array $request)
    {
        // Paste exists?
        if(HttpRequest::post('post_poked') === false && $this->pasteExists($request['id']) === false) {
            return $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'), true);
        }

        // Banned IP
        if($this->clientIpIsBanned() === true && HttpRequest::post('post_poked') !== false) {
            return $this->sendFriendlyClientError(_('You have no permissions to send paste.'));
        }

        // Empty fields
        if(HttpRequest::isEmptyField([
            HttpRequest::post('post_paste_content'),
            HttpRequest::post('post_paste_title', true),
            HttpRequest::post('post_paste_author', true)
		  ], HttpRequest::post('post_paste_content')) && 
            $this->pasteExists($request['id']) === false
        ) {
            return $this->sendFriendlyClientError(_('Some field there are empty or contains prohibited characters (e.g only spaces).'));
        }

        // Antyflood
        if($this->isFloodedClient() === true) {
            return $this->sendFriendlyClientError(
                sprintf(_('Anty-flood is enabled. Please wait at least %d seconds before attempting to send paste again.'), 
                    $this->config()->antyflood_delay_in_seconds));
        }

        // Storage to database paste if doesn't exists
        if($this->pasteExists($request['id']) === false) {
            (new SendPaste($this->application))->send($this->toSendDataContainer($request));
        }

        // If we not have any client error, begin read paste from the database
        $this->paste_data = (new ReadPaste($this->application))->read($request['id']);
        
        // Template render
        $this->render([
            'paste' => $this->paste_data
        ]);

        return $this->{'ReadPaste'};
    }

    /**
    * Paste data to send container
    *
    * @param array $request
    * @return array
    */
    private function toSendDataContainer(array $request)
    {
        return [
            'paste_id' => $request['id'],
            'paste_time' => time(),
            'paste_size' => $this->stringToBytes(HttpRequest::post('post_paste_content')),
            'paste_length' => strlen(HttpRequest::post('post_paste_content')),
            'paste_syntax' => (new SyntaxHighlighter)->validateLanguage(HttpRequest::post('post_syntax_highlight_language')),
            'paste_content' => (new SyntaxHighlighter)->parseCode(HttpRequest::post('post_paste_content'),
                strtolower(HttpRequest::post('post_syntax_highlight_language')), $this->startListCountingFromLine(),
                    HttpRequest::post('post_checkbox_line_numbering')),
            'paste_client_ip' => HttpRequest::getClientIpAddress(),
            'paste_raw_content' => HttpRequest::post('post_paste_content'),
            'paste_title' => HttpRequest::post('post_paste_title', true),
            'paste_author' => HttpRequest::post('post_paste_author', true),
            'paste_start_from_line' => $this->startListCountingFromLine()
        ];
    }

    /**
    * Anty-flood
    *  
    * @return bool
    */
    private function isFloodedClient()
    {
        // Enabled?
        if($this->config()->antyflood_enabled === false || HttpRequest::post('post_poked') === false) {
            return false;
        }

        // Search client IP from Database
        $query = $this->data_source
        ->get()
        ->prepare('SELECT ip_address FROM ' . $this->config('Database')->prefix . 'pastes WHERE ip_address = :ip_address');

        // Filter and execute
        $query->bindValue(':ip_address', HttpRequest::getClientIpAddress());
        $query->execute();

        $rows = $query->fetchAll();

        // Test
        if(!is_array($rows) || !count($rows)) {
            return false;
        }

        // Is flood?
        $query = $this->data_source
        ->get()
        ->prepare('SELECT ip_address, time FROM ' . $this->config('Database')->prefix . 'pastes WHERE ip_address = :ip_address 
            AND time >= :time');

        // Filter and execute
        $query->bindValue(':ip_address', HttpRequest::getClientIpAddress());
        $query->bindValue(':time', time() - $this->config()->antyflood_delay_in_seconds);
        $query->execute();

        $rows = $query->fetchAll();

        // Test
        if(!is_array($rows) || !count($rows)) {
            return false;
        }

        return true;
    }

    /**
    * Banned IP's
    *  
    * @return bool
    */
    private function clientIpIsBanned()
    {
        // Enabled?
        if(is_array($this->config()->banned_ip) === false || !count($this->config()->banned_ip)) {
            return false;
        }

        foreach($this->config()->banned_ip as $banned_ip) {
            // Wildcard
            $banned_ip = str_replace(['*', '.'], ['(\d+)', '\.'], $banned_ip);

            // Test
            if(preg_match('/' . $banned_ip . '/', HttpRequest::getClientIpAddress())) {
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
    */
    public function rawModeAction(array $request)
    {
        // Paste exists?
        if(HttpRequest::post('post_poked') === false && $this->pasteExists($request['id']) === false) {
            return $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'));
        }

        // Set headers
        header('Content-type: text/plain');

        // If we not have any client error, begin read paste from the database
        $this->paste_data = (new ReadPaste($this->application))->read($request['id']);

        // Template render
        $this->render([
            'raw_content' => $this->paste_data['raw_content']
        ]);

        return $this->{'RawMode'};
    }

    /**
    * Embed
    * 
    * @param array $request
    * @return void
    */
    public function embedAction(array $request)
    {
        /// Paste exists?
        if(HttpRequest::post('post_poked') === false && $this->pasteExists($request['id']) === false) {
            die(_('Requested paste doesn\'t exists.'));
        }
        
        // If we not have any client error, begin read paste from the database
        $this->paste_data = (new ReadPaste($this->application))->read($request['id']);

        // Template render
        $this->render([
            'paste' => $this->paste_data,
        ]);

        return $this->{'Embed'};        
    }

    /**
    * Start from line
    * 
    * @return int
    */
    private function startListCountingFromLine()
    {
        // Default value
        $start_from_line = 1;

        // Selected by client
        if(HttpRequest::post('post_start_from_line')) {
            // Valid integer
            if(!preg_match('/\d+/', HttpRequest::post('post_start_from_line'))) {
                $start_from_line = 1;
            } else {
                $start_from_line = (int)HttpRequest::post('post_start_from_line');
            }
        }

        return $start_from_line;
    }

    /**
    * Convert string to bytes (or KB)
    *
    * @param string $string
    * @return int
    */
    private function stringToBytes($string)
    {
        $length = strlen($string);
        $pow = pow(10, 0);

        return round($length / (pow(1024, 0) / $pow)) / $pow;
    }

    /**
    * Download action
    * 
    * @param array $request 
    * @return string
    */
    public function downloadAction(array $request)
    {
        // Paste exists?
        if(HttpRequest::post('post_poked') === false && $this->pasteExists($request['id']) === false) {
            return $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'));
        }

        // Set headers
        header('Content-type: text/plain');
        header('Content-Disposition: attachment; filename="' . $request['id'] . '.txt"');

        // If we not have any client error, begin read paste from the database
        $this->paste_data = (new ReadPaste($this->application))->read($request['id']);

        // Print
        echo $this->paste_data['raw_content'];
    }

    /**
    * Paste exists
    * 
    * @param int $paste_id 
    * @return bool
    */
    private function pasteExists($paste_id)
    {
        // Prepare query
        $query = $this->data_source
        ->get()
        ->prepare('SELECT unique_id FROM ' . $this->config('Database')->prefix . 'pastes WHERE unique_id = :paste_id');

        // Filter and execute
        $query->bindValue(':paste_id', $paste_id, constant('PDO::PARAM_INT'));
        $query->execute();

        $rows = $query->fetchAll();

        // Test
        if(is_array($rows) && count($rows)) {
            return true;
        }

        return false;
    }
}
