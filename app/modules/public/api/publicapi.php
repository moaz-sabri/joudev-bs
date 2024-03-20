<?php

namespace App\Modules\Public\Api;

use App\Utilities\Utilitie;

class PublicApi extends Utilitie
{
    private $response;
    private $callback;
    private $responseMessage;
    private $errorsResponse;

    public function allowedPolicy()
    {
        return (object)[
            'message' => $this->responseMessage,
            'response' => $this->response,
            'callback' => $this->callback,
            'errors' => $this->errorsResponse,
        ];
    }
}
