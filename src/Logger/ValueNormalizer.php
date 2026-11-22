<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusLogger. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Logger;

/**
 * ログの値の整形
 */
class ValueNormalizer
{
    /**
     * 例外を、秘密が出ない文字列に置き換える
     * @param object|array|string|int|float|bool|null $value  ログ内容
     * @param array                                   $params パラメーター
     * @return array [ログ内容, パラメーター]
     */
    public static function normalize(object|array|string|int|float|bool|null $value, array $params): array
    {
        if ($value instanceof \Throwable)
        {
            // 例外の文に % が入っていても壊れないよう、パラメーターとして渡す
            return ['%s', [ThrowableFormatter::format($value)]];
        }

        // パラメーターに渡された例外も置き換える
        return [$value, array_map(self::scalarize(...), $params)];
    }

    /**
     * 表示用の値にする
     * @param object|array|string|int|float|bool|null $value  ログ内容
     * @param array                                   $params パラメーター
     * @return object|array|string|int|float|bool|null
     */
    public static function display(
        object|array|string|int|float|bool|null $value,
        array $params
    ): object|array|string|int|float|bool|null {
        return (is_string($value) === true ? vsprintf($value, $params) : $value);
    }

    /**
     * パラメーターが例外なら、秘密が出ない文字列にする
     * @param object|array|string|int|float|bool|null $param パラメーター
     * @return object|array|string|int|float|bool|null
     */
    private static function scalarize(
        object|array|string|int|float|bool|null $param
    ): object|array|string|int|float|bool|null {
        return ($param instanceof \Throwable ? ThrowableFormatter::format($param) : $param);
    }
}
