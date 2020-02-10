<?php

namespace App\Support\Api\Traits;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

trait ResponseWithErrors
{
    protected static $STATUS_CODE_SUCCESS = 200;
    protected static $STATUS_CODE_CREATED = 201;
    protected static $STATUS_CODE_UPDATED = 202;
    protected static $STATUS_CODE_DELETED = 204;
    protected static $STATUS_CODE_NOT_FOUND_ERROR = 404;
    protected static $STATUS_CODE_VALIDATION_ERROR = 422;

    /**
     * Create structure to response errors with json.
     *
     * @param $error
     * @param int $code
     * @return ResponseFactory|Response
     */
    protected function responseWithErrors($error, $code = 500)
    {
        $body = [
            'errors' => null,
            'count' => 0
        ];

        if ($error instanceof \App\Support\Validation\ValidationException) {
            $body['errors'] = $error->all();
            $body['count'] = $error->count();

            if (\App::environment('local')) {
                $body['debugMessage'] = $error->getMessage();
                $body['stackTrace'] = $error->getTrace();
            }
        }

        if (is_string($error)) {
            $body['errors'][] = $error;
            $body['count'] = 1;
        }

        return response($body, $code);
    }
}
