<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusLogger. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Logger;

class Level
{
    /** @var string trace */
    public const TRACE = 'trace';

    /** @var string debug */
    public const DEBUG = 'debug';

    /** @var string info */
    public const INFO = 'info';

    /** @var string notice */
    public const NOTICE = 'notice';

    /** @var string warning */
    public const WARNING = 'warning';

    /** @var string error */
    public const ERROR = 'error';

    /** @var string critical */
    public const CRITICAL = 'critical';

    /** @var string alert */
    public const ALERT = 'alert';

    /** @var string fatal */
    public const FATAL = 'fatal';

    /** @var string[]  */
    public static $LEVELS = [
        self::TRACE,
        self::DEBUG,
        self::INFO,
        self::NOTICE,
        self::WARNING,
        self::ERROR,
        self::CRITICAL,
        self::ALERT,
        self::FATAL,
    ];
}
