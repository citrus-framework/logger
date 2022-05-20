<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusLogger. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Logger;

/**
 * ログレベルの列挙
 */
enum Level
{
    case TRACE;
    case DEBUG;
    case INFO;
    case NOTICE;
    case WARNING;
    case ERROR;
    case CRITICAL;
    case ALERT;
    case FATAL;
}
