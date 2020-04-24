<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2019, CitrusFramework. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test;

use Citrus\Logger;
use PHPUnit\Framework\TestCase;

/**
 * ロガー処理のテスト
 */
class LoggerTest extends TestCase
{
    use TestFile;

    /** @var Logger */
    public $logger;



    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        // ロガー初期化はbootstrapでしている
        $this->logger = Logger::sharedInstance();
    }



    /**
     * {@inheritDoc}
     */
    public function tearDown(): void
    {
        parent::tearDown();

        if (Logger\File::class === $this->logger->configures['type'])
        {
            // ディレクトリがあったら削除
            $this->forceRemove($this->logger->configures['directory']);
        }
    }



    /**
     * @test
     */
    public function ファイル出力できる()
    {
        // 出力
        Logger::info('testtest');
    }
}
