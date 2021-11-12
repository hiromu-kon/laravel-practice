<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\DBAccess;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($dBA)
    {

        
    }

    /**
     * Select文のサンプル
     *
     * @return array
     */
    public function getTest(Request $request)
    {

        $where = "";
        $bind  = [];
        // $query = $request->input('query');
        // if ($query) {

        //     $where = "where name like N'%$query%'";
        // }

        $dbAccess = execSelect("
            select *
            from test"
        );

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

        $idCount = \DB::select("
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

        \DB::delete("
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
