<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Select文のサンプル
     *
     * @return array
     */
    public function getTest(Request $request)
    {

        $query    = $request->input('query');
        $dbAccess = DB::select("
            select *
            from test
        ");

        $response = array(
            "success" => "true",
            "message" => "",
            "item"    => $dbAccess
        );

        return $response;
    }

    /**
     * Insert文のサンプル
     *
     * @return array
     */
    public function insertTest(Request $request)
    {

        $idCount = DB::select("
            select count(*) as Id
            from test
        ");

        $id = $idCount[0]->Id + 1;

        DB::insert("
            insert into test
                (id, name)
            values
                (:id, :name)
        ", [
            "id"   => $id,
            "name" => $request->input('name')
        ]);

        $response = array(
            "success" => "true",
            "message" => ""
        );

        return $response;
    }

    /**
     * Delete文のサンプル
     *
     * @return array
     */
    public function deleteTest(Request $request)
    {

        DB::delete("
            delete from test
            where id = :id
        ", [
            "id" => $request->input('id')
        ]);

        $response = array(
            "success" => "true",
            "message" => ""
        );

        return $response;
    }
}
