<?php

namespace SimPas\View;

class ClientError extends View
{
    /**
     * Send error 404 page to client.
     *
     * @return bool
     */
    public function response404()
    {
        header('HTTP/1.1 404 Not Found', true, 404);

        return $this->{'ClientErrors/Response404'};
    }
}
