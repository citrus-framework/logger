<?php

require __DIR__ . '/../vendor/autoload.php';

define('UNIT_TEST', true);

// 設定ファイル
$configure_path = dirname(__DIR__). '/tests/citrus-configure.php';

// ロガー初期化
$configures = include($configure_path);
\Citrus\Logger::sharedInstance()->loadConfigures($configures);
