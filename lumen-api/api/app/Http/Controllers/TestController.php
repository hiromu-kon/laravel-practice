<?php

namespace App\Http\Controllers;
use App\Libs\DBAccess;
use App\Traits\JsonRespondController;

/**
 * TestController
 *
 * Class TestController
 * @package App\Http\Controllers
 */
class TestController extends BaseController
{
    use JsonRespondController;

    /**
     * DBアクセス共通クラス
     *
     * @var DBAccess
     */
    private $dba;

    /**
     * コンストラクタ
     *
     * TestController constructor
     * @param \App\Libs\DBAccess $dba
     * @param \App\Libs\ExampleController $example
     */
    public function __construct(DBAccess $dba)
    {

        $this->dba     = $dba;
    }

    /**
     * Select文のサンプル
     *
     * @return array
     * @throws \Exception
     */
    public function getTest()
    {

        $response["item"] = $this->dba->execSelectWithLog("Example", "
            select *
            from test
        ");

        return $this->respondNotFound();

        // throw new \Exception("エラーだよ");

        // return $response;
    }
}
