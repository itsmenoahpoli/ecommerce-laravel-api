<?php

namespace App\Services;

class APIErrorHandlerService
{
    public function handleApiError($error, $httpStatusCode = 500)
    {
        return response()->error($error, $httpStatusCode);
    }
}
