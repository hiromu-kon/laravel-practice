<?php

namespace App\Http\Controllers;
use App\Traits\JsonRespondController;

use Illuminate\Http\Exceptions\HttpResponseException;
use App\Exceptions\ValidationException;

/**
 * BaseController
 *
 * Class BaseController
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{

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

        throw new ValidationException($request, $validator);

        // $data = [
        //     'error' => [
        //         'code' => 30,
        //         'message' => $validator->errors()->toArray()
        //     ],
        // ];

        // return $data;

        // throw new HttpResponseException(response()->json($data, 422));

    }
}
