<?php

namespace App\Libs;

/**
 * DBアクセス共通クラス
 *
 * Class DBAccess
 * @package App\Libs
 */
class DBAccess
{

    /**
     * info系ログ出力
     *
     * @param $text
     * @param array $detail
     */
    private function logInfo($text, $detail = [])
    {

        \Log::info($text, $detail);
    }

    /**
     * 抽出実行
     *
     * @param $query
     * @param array $binds
     * @return mixed
     * @throws \Exception
     */
    public function execSelect($query, $binds = []) 
    {

        return \DB::select($query, $binds);
    }

    /**
     * 抽出実行（開始と終了にログ出力）
     *
     * @param $name
     * @param $query
     * @param array $binds
     * @return mixed
     */
    public function execSelectWithLog($name, $query, $binds = [])
    {

        $this->logInfo($name . "抽出開始", ["クエリ" => $query, "バインド" => $binds]);

        $selected = $this->execSelect($query, $binds);

        $this->logInfo($name . "抽出完了", ["実行結果" => $selected]);

        return $selected;
    }

    /**
     * 挿入実行
     *
     * @param $name
     * @param $query
     * @param $binds
     */
    public function execInsert($name, $query, $binds = [])
    {

        $outputLog = !Common::isEmpty($name);

        if (is_array($query)) {

            foreach ($query as $index => $queryItem) {

                if ($outputLog) {

                    $this->logInfo($name . "登録開始(" . ($index + 1) . "回目)", ["クエリ" => $query, "バインド" => $binds]);
                }

                \DB::insert($queryItem, $binds);

                if ($outputLog) {

                    $this->logInfo($name . "登録完了(" . ($index + 1) . "回目)", ["クエリ" => $queryItem]);
                }
            }
        } else {

            if ($outputLog) {

                $this->logInfo($name . "登録開始", ["クエリ" => $query, "バインド" => $binds]);
            }

            \DB::insert($query, $binds);

            if ($outputLog) {

                $this->logInfo($name . "登録完了", ["クエリ" => $query]);
            }
        }
    }

    /**
     * 削除実行
     *
     * @param $name
     * @param $query
     * @param $binds
     */
    public function execDelete($name, $query, $binds = [])
    {
        $outputLog = !Common::isEmpty($name);

        if ($outputLog) {

            $this->logInfo($name . "削除開始");
        }

        $deleted = [];

        // if ($outputLog) {

        //     $deleted = $this->execSelect("select * from $query", $binds);
        // }

        \DB::delete("delete from $query", $binds);

        if ($outputLog) {

            $this->logInfo($name . "削除完了", ["対象" => $deleted, "バインド" => $binds]);
        }
    }

    /**
     * テーブルのカラム型を取得する
     *
     * @param string $tableName
     * @return array
     */
    public function getColumnTypes($tableName)
    {

        $typeList = [];

        foreach ($this->execSelect("
            select
                COLUMN_NAME as ColumnName,
                DATA_TYPE   as TypeName
            from
                INFORMATION_SCHEMA.COLUMNS
            where
                TABLE_NAME  = :TableName
            order by
                ORDINAL_POSITION
        ", [
            "TableName" => $tableName
        ]) as $type) {

            $typeList[$type->ColumnName] = $type->TypeName;
        }

        return $typeList;
    }
}
