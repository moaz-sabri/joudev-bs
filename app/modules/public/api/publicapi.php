<?php

namespace App\Modules\Public\Api;

use App\Bootstrap\JsonResponse;
use App\Utilities\Utilitie;

class PublicApi extends Utilitie
{
    private $response;
    private $callback;
    private $responseMessage;
    private $errorsResponse;
}
