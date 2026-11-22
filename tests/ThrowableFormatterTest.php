<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2026, CitrusLogger. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test;

use Citrus\Logger\ThrowableFormatter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * 例外の整形のテスト
 */
class ThrowableFormatterTest extends TestCase
{
    #[Test]
    public function 一行目に例外の情報が出る()
    {
        $exception = new \RuntimeException('メッセージ');

        $actual = ThrowableFormatter::format($exception);

        $lines = explode(PHP_EOL, $actual);
        $expected = sprintf('RuntimeException: メッセージ in %s:%d', __FILE__, $exception->getLine());
        $this->assertSame($expected, $lines[0]);
        $this->assertStringContainsString('#0 ', $lines[1]);
        $this->assertStringContainsString('{main}', $lines[count($lines) - 1]);
    }

    #[Test]
    public function previousが続く()
    {
        $previous = new \LogicException('原因');
        $exception = new \RuntimeException('結果', 0, $previous);

        $actual = ThrowableFormatter::format($exception);

        $this->assertStringContainsString('RuntimeException: 結果 in ', $actual);
        $this->assertStringContainsString(
            sprintf('Caused by: LogicException: 原因 in %s:%d', __FILE__, $previous->getLine()),
            $actual
        );
    }

    #[Test]
    public function 引数の秘密は出ない()
    {
        try
        {
            $this->throwWith('topsecret');
        }
        catch (\Throwable $e)
        {
            $actual = ThrowableFormatter::format($e);
        }

        $this->assertStringContainsString('throwWith', $actual);
        $this->assertStringNotContainsString('topsecret', $actual);
    }

    /**
     * 引数付きで呼ばれて例外を投げる
     * @param string $secret
     */
    private function throwWith(string $secret): void
    {
        throw new \RuntimeException('失敗');
    }
}
