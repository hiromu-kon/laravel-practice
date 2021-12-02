<?php

namespace App\Libs;

/**
 * 共通クラス
 *
 * Class Common
 * @package App\Libs
 */
class Common
{

    /**
     * escape句で指定するlike用エスケープ文字
     *
     * @var string
     */
    const ESCAPE_CHAR_USED_LIKE_PREDICATE = "!";

    /**
     * insertできるvalueの最大値
     */
    const MAX_INSERT_VALUES = 100;

    /**
     * 空かどうか
     *
     * @param $value
     * @return bool
     */
    public static function isEmpty($value)
    {

        return $value === null || $value === "";
    }

    /**
     * dateのmin、max値取得
     *
     * @return array
     */
    public static function getMinMaxDate()
    {

        return array(
            "MinDate" => "1900-01-01",
            "MaxDate" => "2999-12-31"
        );
    }

    /**
     * 日付の比較
     *
     * @param $begin
     * @param $end
     * @return bool
     */
    public static function dateCompare($begin, $end)
    {

        return date($begin) <= date($end);
    }

    /**
     * SQLパラメータのエスケープ処理
     *
     * @param string $param
     * @param boolean $isLikePredicate
     * @return string
     */
    public static function escapeSpecialCharactersForSql($param, $isLikePredicate = false)
    {

        $searches = array("'");
        $replaces = array("''");

        if ($isLikePredicate) {

            array_push(
                $searches,
                self::ESCAPE_CHAR_USED_LIKE_PREDICATE,
                "%",
                "_",
                "["
            );

            array_push(
                $replaces,
                self::ESCAPE_CHAR_USED_LIKE_PREDICATE . self::ESCAPE_CHAR_USED_LIKE_PREDICATE,
                self::ESCAPE_CHAR_USED_LIKE_PREDICATE . "%",
                self::ESCAPE_CHAR_USED_LIKE_PREDICATE . "_",
                self::ESCAPE_CHAR_USED_LIKE_PREDICATE . "["
            );
        }

        return str_replace($searches, $replaces, $param);
    }
}
