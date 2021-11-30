<?php

namespace App;

use Monolog\Logger;
use Laravel\Lumen\Application as LumenApplication;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\NewRelicHandler;
use Monolog\Handler\RotatingFileHandler;

class Application extends LumenApplication
{

    /**
     * Register container bindings for the application.
     *
     * @return void
     */
    protected function registerLogBindings()
    {
        $this->singleton('Psr\Log\LoggerInterface', function () {
            return new Logger('lumen', $this->getMonologHandler());
        });
    }

    /**
     * Extends the default logging implementation with additional handlers if configured in .env
     *
     * @return array of type \Monolog\Handler\AbstractHandler
     */
    protected function getMonologHandler()
    {

        $errorLogger = new RotatingFileHandler(storage_path("logs/{date}/error.log"), 0, Logger::ERROR, false);
        $infoLogger = new RotatingFileHandler(storage_path("logs/{date}/info.log"), 0, Logger::INFO, false);
        $debugLogger = new RotatingFileHandler(storage_path("logs/{date}/debug.log"), 0, Logger::DEBUG, false);

        $handlers = [];
        $handlers[] = $this->setLoggerFileFormat($errorLogger);
        $handlers[] = $this->setLoggerFileFormat($infoLogger);
        $handlers[] = $this->setLoggerFileFormat($debugLogger);

        return $handlers;

    }

    /**
     * Loggerのファイル名と日付フォーマットを設定
     *
     * @param $logger
     * @return mixed
     */
    private function setLoggerFileFormat($logger) {

        $logger->setFilenameFormat('{filename}-{date}', 'Y-m-d');
        $dateFormat = "Y-m-d H:i:s";
        $logger->setFormatter(new LineFormatter(null, $dateFormat, true, true));

        return $logger;
    }

}
