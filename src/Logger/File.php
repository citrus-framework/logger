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
 * ファイル出力ロガー
 */
class File implements LogOutput
{
    use Structs;

    /** @var string */
    public string $directory;

    /** @var string */
    public string $filename;

    /** @var string */
    public string $owner = 'wwwrun';

    /** @var string */
    public string $group = 'www';

    /** @var int */
    public int $mode = 0666;



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
     * output log file
     *
     * @param mixed $value  ログ内容
     * @param array $params パラメーター
     * @return void
     */
    public function output(mixed $value, array $params = []): void
    {
        // ログファイル名
        $filepath = sprintf(
            '%s%s-%s',
            $this->directory,
            $this->filename,
            date('Ymd', $_SERVER['REQUEST_TIME'])
        );

        // 出力データ
        $vl_dump = (true === is_string($value)
            ? vsprintf($value, $params) . PHP_EOL
            : var_export($value, true));
        $data = date('[Y-m-d H:i:s] ', $_SERVER['REQUEST_TIME']) . htmlspecialchars_decode(strip_tags($vl_dump));

        // ファイル書き込み
        $this->write($filepath, $data);
    }



    /**
     * ファイル書き込み
     *
     * @param string $filepath ファイルパス
     * @param string $data     データ文字列
     */
    private function write(string $filepath, string $data): void
    {
        // log file exist
        $file_exist = file_exists($filepath);

        // writing log
        $file = @fopen($filepath, 'a+');
        if (false === $file and true === mkdir(dirname($filepath), 0777, true))
        {
            $file = fopen($filepath, 'a+');
        }
        fwrite($file, $data);
        fclose($file);

        // file added permission
        if (false === $file_exist)
        {
            chmod($filepath, $this->mode);
            chown($filepath, $this->owner);
            chgrp($filepath, $this->group);
        }
    }
}
