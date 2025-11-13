<?php

declare(strict_types=1);

namespace App\Helpers\Logging;

use Illuminate\Log\Logger;
use Monolog\Handler\RotatingFileHandler;

class CustomFilenames
{
    /**
     * Customize the given logger instance.
     *
     * @param  Logger  $logger
     */
    public function __invoke($logger): void
    {
        foreach ($logger->getHandlers() as $handler)
        {
            if ($handler instanceof RotatingFileHandler)
            {
                $sapi = PHP_SAPI;
                $handler->setFilenameFormat("{filename}-{$sapi}-{date}", 'Y-m-d');
            }
        }
    }
}
