<?php

namespace App\Exceptions;

use Exception;

class BadRequestException extends Exception
{
    public $message;

    public function __construct($message)
    {

        $this->message = $message;
    }

    public function report()
    {
        //
    }

    public function render()
    {
        return response()->json(
            array(
                "code"    => 400,
                "message" => $this->message
            ),
            400
        );
    }
}
