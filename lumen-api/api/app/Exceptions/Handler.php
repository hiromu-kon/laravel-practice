<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;
use App\Traits\JsonRespondController;
use Throwable;

class Handler extends ExceptionHandler
{
    use JsonRespondController;
    
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        // if ($this->isHttpException($exception)) {

        //     $status = $exception->getStatusCode();
        // }

        // if ($this->shouldReport($exception) && !$this->isHttpException($exception)) {

        //     $status = 500;
        // }


        return parent::render($request, $exception);
    }

    /**
     * Get the json response for the exception.
     *
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponse(Exception $exception)
    {
        $debugEnabled = config('app.debug');

        $exception = $this->prepareException($exception);

        /*
         * Handle validation errors thrown using ValidationException.
         */
        if ($exception instanceof ValidationException) {

            $validationErrors = $exception->validator->errors()->getMessages();

            $validationErrors = array_map(function($error) {
                return array_map(function($message) {
                    return remove_words($message, 2);
                }, $error);
            }, $validationErrors);

            return response()->json(['errors' => $validationErrors], 422);
        }

        /*
         * Handle database errors thrown using QueryException.
         * Prevent sensitive information from leaking in the error message.
         */
        if ($exception instanceof QueryException) {
            if ($debugEnabled) {
                $message = $exception->getMessage();
            } else {
                $message = 'Internal Server Error';
            }
        }

        $statusCode = $this->getStatusCode($exception);

        if (! isset($message) && ! ($message = $exception->getMessage())) {
            $message = sprintf('%d %s', $statusCode, Response::$statusTexts[$statusCode]);
        }

        $errors = [
            'message' => $message,
            'status_code' => $statusCode,
        ];

        if ($debugEnabled) {
            $errors['exception'] = get_class($exception);
            $errors['trace'] = explode("\n", $exception->getTraceAsString());
        }

        return response()->json(['errors' => $errors], $statusCode);
    }

    /**
     * Get the status code from the exception.
     *
     * @param \Exception $exception
     * @return int
     */
    protected function getStatusCode(Exception $exception)
    {
        return $this->isHttpException($exception) ? $exception->getStatusCode() : 500;
    }
}
