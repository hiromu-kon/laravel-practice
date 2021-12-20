<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ValidationException extends Exception
{
    public $request;
    public $message;

    public function __construct(Request $request, $validator)
    {
        $this->request = $request;
        $this->validator = $validator;
    }

    public function report()
    {
        $xRequestId = array_key_exists('x-request-id', $this->request->header()) ? $this->request->header()['x-request-id'][0] : '';
        Log::info(
            $xRequestId,
            [
                'client_ip'      => $this->request->getClientIp(),
                'request_params' => $this->request->all()
            ]
        );
    }

    public function render()
    {
        return response()->json(
            array(
                "code"    => 422,
                "message" => $this->validator->errors()
            ),
            422
        );
    }
}
