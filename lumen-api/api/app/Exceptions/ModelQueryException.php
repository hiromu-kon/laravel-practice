<?php

namespace App\Exceptions;

use Exception;

/**
 * カスタム例外クラス: ModelQueryException 500
 *
 * Class ModelQueryException
 * @package App\Exceptions
 */
class ModelQueryException extends Exception
{

    /**
     * @var $message
     */
    protected $message;

    /**
     * ModelQueryException constructor
     * 
     * @param $message
     */
    public function __construct($message)
    {

        $this->message = $message;
    }

    /**
     * report
     */
    public function report()
    {
        //
    }

    /**
     * render
     * 
     * @return JsonResponse
     */
    public function render()
    {
        return response()->json(
            array(
                "code"    => 500,
                "message" => $this->message
            ),
            500
        );
    }
}
