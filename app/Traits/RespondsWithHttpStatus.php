<?php

namespace App\Traits;

trait RespondsWithHttpStatus
{
    protected function success($message = '', $data = [], $type = '',$status = 200)
    {
        return response([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => [
                'organization' => 'NTI'
            ],
            'type'=> $type,
        ], $status);
    }

    protected function failure($message = '', $type = '' ,$status = 422)
    {
        return response([
            'success' => false,
            'message' => $message,
            'meta' => [
                'organization' => 'NTI'
            ],
            'type'=> $type,
        ], $status);
    }
}
