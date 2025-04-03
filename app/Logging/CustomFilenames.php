<?php

namespace App\Logging;

use Illuminate\Log\Logger;
use Monolog\Handler\RotatingFileHandler;

class CustomFilenames
{
    /**
     * Customize the given logger instance.
     *
     * @param Logger $logger
     * @return void
     */
    public function __invoke($logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            if ($handler instanceof RotatingFileHandler) {
                $sapi = php_sapi_name();
                $handler->setFilenameFormat("{filename}-$sapi-{date}", 'Y-m-d');
            }
        }
    }
}
