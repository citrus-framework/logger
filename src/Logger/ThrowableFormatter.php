<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusLogger. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Logger;

/**
 * 例外の整形（トレースの引数は書かない）
 */
class ThrowableFormatter
{
    /**
     * 例外を文字列にする
     * @param \Throwable $throwable 例外
     * @return string
     */
    public static function format(\Throwable $throwable): string
    {
        $lines = [];
        $prefix = '';
        $current = $throwable;

        // previous をたどる
        while ($current !== null)
        {
            $lines[] = $prefix . sprintf(
                '%s: %s in %s:%d',
                $current::class,
                $current->getMessage(),
                $current->getFile(),
                $current->getLine()
            );

            // トレース
            $trace = $current->getTrace();
            foreach ($trace as $index => $frame)
            {
                $lines[] = sprintf('#%d %s', $index, self::formatFrame($frame));
            }
            $lines[] = sprintf('#%d {main}', count($trace));

            $prefix = 'Caused by: ';
            $current = $current->getPrevious();
        }

        return implode(PHP_EOL, $lines);
    }

    /**
     * トレース1件を文字列にする（args は使わない）
     * @param array $frame トレースの要素
     * @return string
     */
    private static function formatFrame(array $frame): string
    {
        // 場所
        $location = '[internal function]';
        if (isset($frame['file']) === true)
        {
            $location = sprintf('%s(%s)', $frame['file'], $frame['line'] ?? '');
        }

        // 呼び出し
        $call = sprintf(
            '%s%s%s()',
            $frame['class'] ?? '',
            $frame['type'] ?? '',
            $frame['function'] ?? ''
        );

        return $location . ': ' . $call;
    }
}
