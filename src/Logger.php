<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusLogger. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus;

use Citrus\Configure\Configurable;
use Citrus\Logger\File;
use Citrus\Logger\Level;
use Citrus\Logger\LogOutput;
use Citrus\Variable\Dates;
use Citrus\Variable\Singleton;

/**
 * ログ処理
 */
class Logger extends Configurable
{
    use Singleton;

    /** @var LogOutput ログタイプ別のインスタンス */
    protected LogOutput $logger;



    /**
     * {@inheritDoc}
     */
    public function loadConfigures(array $configures = []): Configurable
    {
        // 設定配列の読み込み
        parent::loadConfigures($configures);

        // タイプによって生成インスタンスを分ける
        $type = $this->configures['type'];

        // インスタンス生成
        $this->logger = new $type($this->configures);

        return $this;
    }



    /**
     * trace log file
     *
     * @param mixed $value
     */
    public static function trace(mixed $value): void
    {
        self::sharedInstance()->output(Level::TRACE, $value, func_get_args());
    }



    /**
     * debug log file
     *
     * @param mixed $value
     */
    public static function debug(mixed $value): void
    {
        self::sharedInstance()->output(Level::DEBUG, $value, func_get_args());
    }



    /**
     * info log file
     *
     * @param mixed $value
     */
    public static function info(mixed $value): void
    {
        self::sharedInstance()->output(Level::INFO, $value, func_get_args());
    }



    /**
     * warn log file
     *
     * @param mixed $value
     */
    public static function warn(mixed $value): void
    {
        self::sharedInstance()->output(Level::WARNING, $value, func_get_args());
    }



    /**
     * error log file
     *
     * @param mixed $value
     */
    public static function error(mixed $value): void
    {
        self::sharedInstance()->output(Level::ERROR, $value, func_get_args());
    }



    /**
     * fatal log file
     *
     * @param mixed $value
     */
    public static function fatal(mixed $value): void
    {
        self::sharedInstance()->output(Level::FATAL, $value, func_get_args());
    }



    /**
     * output log file
     *
     * @param Level  $level  ログレベル
     * @param mixed  $value  ログの内容
     * @param array  $params パラメータ
     * @return void
     */
    public function output(Level $level, $value, array $params): void
    {
        // ログレベルによる出力許容チェック
        if (false === self::isOutputableLevel($level))
        {
            return;
        }

        // パラメーターの一つ目はメソッドなのでずらす
        array_shift($params);

        // 表示
        if (true === $this->configures['display'])
        {
            // 表示情報
            $display_value = (true === is_string($value) ? vsprintf($value, $params) : $value);
            // ダンプ表示
            var_dump([
                Dates::now()->format('Y-m-d H:i:s'),
                $display_value,
            ]);
        }
        $this->logger->output($value, $params);
    }



    /**
     * コンフィグ設定で指定されたログを出力するレベルか判定する
     *
     * @param Level $level ログレベル
     * @return bool
     */
    public function isOutputableLevel(Level $level): bool
    {
        // 出力設定のログレベル
        $configure_level_index = array_search($this->configures['level'], Level::cases(), true);
        // 出力しようとしているログレベル
        $target_level_index = array_search($level, Level::cases(), true);
        // 出力設定のログレベル <= 出力しようとしているログレベル
        return ($configure_level_index <= $target_level_index);
    }



    /**
     * {@inheritDoc}
     */
    protected function configureKey(): string
    {
        return 'logger';
    }



    /**
     * {@inheritDoc}
     */
    protected function configureDefaults(): array
    {
        // ロガータイプ
        $type = ($this->configures['type'] ?? null);

        // 共通
        $defaults = [
            'level' => Level::INFO,
            'display' => false,
        ];

        // ファイルの場合
        if (File::class === $type)
        {
            $defaults += [
                'owner' => posix_getpwuid(posix_geteuid())['name'],
                'group' => posix_getgrgid(posix_getegid())['name'],
                'mode' => 0666,
            ];
        }

        return $defaults;
    }



    /**
     * {@inheritDoc}
     */
    protected function configureRequires(): array
    {
        // ロガータイプ
        $type = ($this->configures['type'] ?? null);

        // 共通
        $requires = [
            'type',
        ];

        // ファイルの場合
        if (File::class === $type)
        {
            $requires += [
                'directory',
                'filename',
                'owner',
                'group',
                'mode',
            ];
        }

        return $requires;
    }
}
