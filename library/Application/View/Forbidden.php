<?php
namespace Application\View;

use Application\View\View;

class Forbidden extends View
{
    /**
    * Send error 404 page to client
    * 
    * @param string $requested_url
    * @param array $routes
    * @return void
    */
    public function response404($requested_url, array $routes = [])
    {
        // Set headers
        header('HTTP/1.1 404 Not Found', true, 404);

        $this->render([
            'requested_url' => $requested_url,
            'routes' => $routes
        ]);

        return $this->{'ForbiddenResponse404'};
    }
}
