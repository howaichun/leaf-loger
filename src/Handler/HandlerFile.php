<?php

declare(strict_types = 1);

namespace Leaf\Loger\Handler;

use Leaf\Loger\Handler\HandlerInterface;

/**
 * file handler
 * Class HandlerFile
 * @package Leaf\Loger\Handler
 */
class HandlerFile extends HandlerBase
{

    protected $logContent = '';
    protected $logFile = '';
    protected $maxFileSize = 0; //10 * 1024
    protected $logMessageFormat = '<timestamp> [-][-][-][<level>][<category>] <message>';

    /**
     * HandlerFile constructor.
     */
    public function __construct()
    {
        //class init
        $this->init();
    }

    public function setLogPath(string $path)
    {
        if (!empty($path)) {
            $this->logFile = $path;
        } else {
            throw new \InvalidArgumentException('you can\'t set empty log path');
        }
    }

    /**
     * init this file handler
     */
    public function init()
    {
        $this->registerFileLogShutDown();
    }

    public function setLogMessageFormat(string $format)
    {
        $this->logMessageFormat = $format;
    }

    /**
     * register a shutdown function so that we can flush log string to file once
     */
    protected function registerFileLogShutDown()
    {
        register_shutdown_function([$this, 'flushLog']);
    }

    public function flushLog()
    {
        if (!empty($this->logMessage)) {
            foreach ($this->logMessage as $message) {
                $searchPattern = [
                    '<level>',
                    '<message>',
                    '<timestamp>',
                    '<category>',
                ];
                $this->logContent .= str_replace($searchPattern, $message) . PHP_EOL;
            }
            $this->flushToFile();
        }
    }

    protected function flushToFile()
    {
        if ($this->maxFileSize === 0) {
            error_log($this->logContent, $this->logFile);
        }
    }

    /**
     * handle log message
     * @param string $level
     * @param string $message
     * @param array $context
     */
    public function handle(string $level, string $message, array $context = [])
    {
        if (empty($level) || empty($message)) {
            throw new \InvalidArgumentException('param error: level or message can\'t be empty');
        }
        $logInfo = [
            'level' => $level,
            'message' => $message,
            'timestamp' => $this->getLogTime(),
            'category' => 'application',
        ];
        $this->logMessage[] = $logInfo;
    }


}