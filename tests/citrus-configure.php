<?php

/**
 * @copyright   Copyright 2020, CitrusLogger. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

$dir_base = dirname(__FILE__) . '/Sample';

return [
    'default' => [
        'application' => [
            'id'        => 'Test\Sample',
            'path'      => $dir_base,
        ],
        'logger' => [
            'type'      => \Citrus\Logger\File::class,
            'rotate'    => [
                'type'  => 'date',
                'limit' => 'day',
            ],
        ],
    ],
    'example.com' => [
        'application' => [
            'name'      => 'CitrusFramework Console.',
            'copyright' => 'Copyright 2019 CitrusFramework System, All Rights Reserved.',
            'domain'    => 'hoge.example.com',
        ],
        'logger' => [
            'directory' => $dir_base . '/log',
            'filename'  => '/hoge.example.com.system_log',
            'level'     => 'debug',
            'display'   => false,
            'owner'     => posix_getpwuid(posix_geteuid())['name'],
            'group'     => posix_getgrgid(posix_getegid())['name'],
            'mode'      => 0666,
        ],
    ],
];
