<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;

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

        $response = array(
            "success"   => true,
            "message"   => ""
        );

        if (count($data) <= 0) {

            return $response;
        }

        $params = $request->all();

        $validator = \Validator::make($params, $data, $customMessages);

        $data = [
            'error' => [
                'code' => 30,
                'message' => $validator->errors()->toArray()
            ],
        ];

        throw new HttpResponseException(response()->json($data, 422));

        if ($validator->fails()) {

            $params     = [];
            $messages   = $validator->messages();

            foreach(json_decode($messages) as $key => $message) {

                $details = [];

                foreach($message as $detail) {

                    $details[] = $detail;
                }

                $params[] = (count($customMessages) > 0 ? "" : $key . ":") . implode("|", $details);
            }

            $response["success"] = false;
            $response["message"] = implode("</br>", $params);
        }

        return $response;
    }
}
