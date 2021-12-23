<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\JsonRespondController;

/**
 * HTTPS判定ミドルウェア
 *
 * Class OnlyHttps
 * @package App\Http\Middleware
 */
class OnlyHttps
{
    use JsonRespondController;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if ((empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on") 
            && app()->environment('production')) {

            return $this->respondBadRequest("リクエストが不正です。");
        }

        return $next($request);
    }
}
