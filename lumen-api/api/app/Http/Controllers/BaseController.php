<?php

namespace App\Http\Controllers;
use App\Traits\JsonRespondController;

use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * BaseController
 *
 * Class BaseController
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
    use JsonRespondController;

    /**
     * パラメータのバリデーションチェック
     *
     * @param $request
     * @param $data
     * @param $customMessages
     * @return array
     */
    public static function validation($request, $data, $customMessages = [])
    {

        $params = $request->all();

        $validator = \Validator::make($params, $data, $customMessages);

        $data = [
            'error' => [
                'code' => 30,
                'message' => $validator->errors()->toArray()
            ],
        ];

        return $data;

        // throw new HttpResponseException(response()->json($data, 422));

    }
}
