<?php
namespace Application\Pastebin;

use Application\Application;
use Application\View\View;
use Application\HttpRequest\HttpRequest;
use Application\Pastebin\ReadPaste;
use Application\Pastebin\Helpers\PasteId;
use Diff;
use Diff_Renderer_Html_Inline;

class Compare extends View
{
    /**
    * Application
    * 
    * @var object
    */
    private $application;
    
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
    }

    /**
    * Compare
    * 
    * @param array $request
    * @return void
    */
    public function compareAction(array $request)
    {
        // Paste exists?
        if((new ReadPaste($this->application))->pasteExists($request['left']) === false) {
            return $this->sendFriendlyClientError(_('Requested paste (left) doesn\'t exists.'), true); 
        }

        if((new ReadPaste($this->application))->pasteExists($request['right']) === false) {
            return $this->sendFriendlyClientError(_('Requested paste (right) doesn\'t exists.'), true); 
        }

        // Include diff lib
        require_once Application::makePath('library/Diff/Diff.php');
        require_once Application::makePath('library/Diff/Diff/Renderer/Html/Inline.php');

        // Get paste content
        $left = (new ReadPaste($this->application))->read($request['left'])['raw_content'];
        $right = (new ReadPaste($this->application))->read($request['right'])['raw_content'];

        // Template render
        $this->render([
            'diff_results' => (new Diff(explode("\n", $left), explode("\n", $right)))->render(new Diff_Renderer_Html_Inline()),
            'left_id' => $request['left'],
            'right_id' => $request['right']
        ]);

        return $this->{'Diff'};
    }

    /**
    * Compare form
    * 
    * @param array $request
    * @return void
    */
    public function formAction(array $request)
    {
        // Paste exists?
        if((new ReadPaste($this->application))->pasteExists($request['left']) === false) {
            return $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'), true);
        }
        
        // Have data from form?
        if(HttpRequest::post('post_compare_right') !== false) {
            // Empty fields
            if(HttpRequest::isEmptyField([HttpRequest::post('post_compare_right')])) {
                return $this->sendFriendlyClientError(_('Some field there are empty or contains prohibited characters (e.g only spaces).'));
            }

            // URL?
            if(filter_var(HttpRequest::post('post_compare_right', 'html'), FILTER_VALIDATE_URL) !== false) {
                if(PasteId::getFromUrl(HttpRequest::post('post_compare_right', 'html')) !== false) {
                    $right = PasteId::getFromUrl(HttpRequest::post('post_compare_right', 'html'));
                } else {
                    return $this->sendFriendlyClientError(_('Submitted URL is not valid.'), true);
                }
            } else {
                $right = HttpRequest::post('post_compare_right', 'html');
            }

            // Paste exists?
            if((new ReadPaste($this->application))->pasteExists($right) === false) {
                return $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'), true);
            }

            // Redirect to compare
            header('Location:' . $this->application->buildUrl('compare/' . $request['left'] . '/with/' . $right));
        }

        // Template render
        $this->render([
            'left_id' => $request['left']
        ]);

        return $this->{'DiffForm'};
    }
}
