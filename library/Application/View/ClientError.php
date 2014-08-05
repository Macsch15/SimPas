<?php
namespace Application\View;

use Application\View\View;

class ClientError extends View
{
    /**
     * Send error 404 page to client
     * 
     * @return void
     */
    public function response404()
    {
        // Set headers
        header('HTTP/1.1 404 Not Found', true, 404);

        return $this->{'ClientErrors/Response404'};
    }
}
