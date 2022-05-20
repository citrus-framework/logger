<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusLogger. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Logger;

use Citrus\Variable\Structs;

/**
 * Syslog出力ロガー
 */
class Syslog implements LogOutput
{
    use Structs;

    /** @var string */
    public string $directory;

    /** @var string */
    public string $filename;



    /**
     * constructor
     *
     * @param array $configure
     */
    public function __construct(array $configure = [])
    {
        $this->bind($configure);
    }



    /**
     * output log syslog
     *
     * @param mixed $value  ログ内容
     * @param array $params パラメーター
     */
    public function output(mixed $value, array $params = []): void
    {
        // 出力データ
        $vl_dump = (true === is_string($value)
            ? vsprintf($value, $params) . PHP_EOL
            : var_export($value, true));
        $data = date('[Y-m-d H:i:s] ', $_SERVER['REQUEST_TIME']) . htmlspecialchars_decode(strip_tags($vl_dump));

        syslog(LOG_INFO, $data);
    }
}
