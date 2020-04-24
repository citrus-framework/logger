<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusLogger. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Logger;

/**
 * ログ出力インターフェース
 */
interface LogOutput
{
    /**
     * output
     *
     * @param mixed $value  ログ内容
     * @param array $params パラメーター
     */
    public function output($value, array $params = []): void;
}
