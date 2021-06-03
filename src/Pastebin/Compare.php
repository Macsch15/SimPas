<?php

namespace SimPas\Pastebin;

use SimPas\Application;
use SimPas\HttpRequest\HttpRequest;
use SimPas\Pastebin\Helpers\PasteId;
use SimPas\View\View;
use Diff;
use Diff_Renderer_Html_Inline;

class Compare extends View
{
    private $application;

    /**
     * Compare constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        parent::__construct($application);

        $this->application = $application;
    }

    /**
     * @param array $request
     * @return bool|void
     * @throws \SimPas\Exception\ExceptionRuntime
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function compareAction(array $request)
    {
        if ((new ReadPaste($this->application))->pasteExists($request['left']) === false) {
            $this->sendFriendlyClientError(_('Requested paste (left) doesn\'t exists.'), true);

            return false;
        }

        if ((new ReadPaste($this->application))->pasteExists($request['right']) === false) {
            $this->sendFriendlyClientError(_('Requested paste (right) doesn\'t exists.'), true);

            return false;
        }

        require Application::makePath('library/Diff/Diff.php');
        require Application::makePath('library/Diff/Diff/Renderer/Html/Inline.php');

        $left = (new ReadPaste($this->application))->read($request['left'])['raw_content'];
        $right = (new ReadPaste($this->application))->read($request['right'])['raw_content'];

        $this->render([
            'diff_results' => (new Diff(explode("\n", $left), explode("\n", $right)))->render(new Diff_Renderer_Html_Inline()),
            'left_id' => $request['left'],
            'right_id' => $request['right'],
        ]);

        return $this->{'Diff'};
    }

    /**
     * @param array $request
     * @return bool|void
     * @throws \SimPas\Exception\ExceptionRuntime
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function formAction(array $request)
    {
        if ((new ReadPaste($this->application))->pasteExists($request['left']) === false) {
            $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'), true);

            return false;
        }

        if (HttpRequest::post('post_compare_right') !== false) {
            if (HttpRequest::isEmptyField([HttpRequest::post('post_compare_right')])) {
                $this->sendFriendlyClientError(_('Some field there are empty or contains prohibited characters (e.g only spaces).'));

                return false;
            }

            if (filter_var(HttpRequest::post('post_compare_right', 'html'), FILTER_VALIDATE_URL) !== false) {
                if (PasteId::getFromUrl(HttpRequest::post('post_compare_right', 'html')) !== false) {
                    $right = PasteId::getFromUrl(HttpRequest::post('post_compare_right', 'html'));
                } else {
                    $this->sendFriendlyClientError(_('Submitted URL is not valid.'), true);

                    return false;
                }
            } else {
                $right = HttpRequest::post('post_compare_right', 'html');
            }

            if ((new ReadPaste($this->application))->pasteExists($right) === false) {
                $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'), true);

                return false;
            }

            header('Location:' . $this->application->buildUrl('compare/' . $request['left'] . '/with/' . $right));
        }

        $this->render([
            'left_id' => $request['left'],
        ]);

        return $this->{'DiffForm'};
    }
}
