<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\DBAccess;
use App\Libs\Common;

/**
 * ExampleController
 *
 * Class ExampleController
 * @package App\Http\Controllers
 */
class ExampleController extends Controller
{

    /**
     * DBアクセス共通クラス
     *
     * @var DBAccess
     */
    protected $dba;

    /**
     * コンストラクタ
     *
     * ExampleController constructor
     * @param \App\Libs\DBAccess $dba
     */
    public function __construct(DBAccess $dba)
    {

        $this->dba = $dba;
    }

    /**
     * Select文のサンプル
     *
     * @param Request $request HTTPリクエスト
     * @return array
     * @throws \Exception
     */
    public function getTest(Request $request)
    {

        $validation = Common::validation($request, [
            "searchId"   => "max:5",
            "searchName" => "max:10"
        ], [
            "searchId.max"   => "Id検索は最大5文字です。",
            "searchName.max" => "名前検索は最大10文字です。"
        ]);

        if (!$validation["success"]) {

            return $validation;
        }

        $response = array(
            "success" => "true",
            "message" => ""
        );

        $wheres     = [];
        $searchId   = Common::escapeSpecialCharactersForSql($request->input('searchId'), true);
        $searchName = Common::escapeSpecialCharactersForSql($request->input('searchName'), true);

        if (!Common::isEmpty($searchId)) {

            $wheres[] = "id like N'%$searchId%'";
        }

        if (!Common::isEmpty($searchName)) {

            $wheres[] = "name like N'%$searchName%'";
        }

        $where = count($wheres) > 0 ? "where " . implode(" and ", $wheres) : "";
        $response["item"] = $dbAccess = $this->dba->execSelectWithLog("Example", "
            select *
            from test
            $where
        ");

        return $response;
    }

    /**
     * Insert文のサンプル
     *
     * @param Request $request HTTPリクエスト
     * @return array
     * @throws \Exception
     */
    public function insertTest(Request $request)
    {

        $id         = $request->input('id');
        $validation = Common::validation($request, [
            "id"   => "required|max:5",
            "name" => "required|max:10"
        ], [
            "id.required"   => "Idは必須入力です。",
            "name.required" => "名前は必須入力です。",
            "id.max"        => "Idは最大5文字です。",
            "name.max"      => "名前は最大10文字です。"
        ]);

        if (!$validation["success"]) {

            return $validation;
        }

        $response = array(
            "success" => "true",
            "message" => ""
        );

        $count = $this->dba->execSelectWithLog("Example", "
            select count(1) as count
            from   test
            where  id = :id
        ", [
            "id" => $id
        ]);

        if ($count[0]->count > 0) {

            $response["success"] = false;
            $response["message"] = "登録済みのIdです。";

            return $response;
        }

        try {

            \DB::beginTransaction();

            $this->dba->execInsert("Example", "
                insert into test
                    (id, name)
                values
                    (:id, :name)
            ", [
                "id"   => $id,
                "name" => $request->input('name')
            ]);

            \DB::commit();
        } catch(\Exception $e) {

            \DB::rollBack();

            $response["success"] = false;
            $response["message"] = $e->getMessage();
            \Log::error($e);

            return $response;
        };

        return $response;
    }

    /**
     * Delete文のサンプル
     *
     * @param Request $request HTTPリクエスト
     * @return array
     * @throws \Exception
     */
    public function deleteTest(Request $request)
    {

        $id = $request->input('id');

        try {

            \DB::beginTransaction();

            $this->dba->execDelete("Example", "test where id = $id");

            \DB::commit();
        } catch(\Exception $e) {

            \DB::rollBack();

            $response["success"] = false;
            $response["message"] = $e->getMessage();
            \Log::error($e);

            return $response;
        }

        $response = array(
            "success" => "true",
            "message" => ""
        );

        return $response;
    }

     /**
     * Update文のサンプル
     *
     * @param Request $request HTTPリクエスト
     * @return array
     * @throws \Exception
     */
    public function updateTest(Request $request)
    {

        $validation = Common::validation($request, [
            "id"   => "required|max:5",
            "name" => "required|max:10"
        ], [
            "id.required"   => "Idは必須入力です。",
            "name.required" => "名前は必須入力です。",
            "id.max"        => "Idは最大5文字です。",
            "name.max"      => "名前は最大10文字です。"
        ]);

        if (!$validation["success"]) {

            return $validation;
        }

        try {

            \DB::beginTransaction();

            $this->dba->execUpdate("Example", "
                update test 
                set name = :name
                where id = :id
            ", [
                "name" => $request->input('name'),
                "id"   => $request->input('id')
            ]);

            \DB::commit();
        } catch(\Exception $e) {

            \DB::rollBack();

            $response["success"] = false;
            $response["message"] = $e->getMessage();
            \Log::error($e);

            return $response;
        }

        $response = array(
            "success" => "true",
            "message" => ""
        );

        return $response;
    }
}
