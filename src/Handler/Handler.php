<?php

declare(strict_types = 1);

namespace Leaf\Loger\Handler;

use Leaf\Loger\LogerClass\LogLevel;

/**
 * Class HandlerBase
 * @package Leaf\Loger\Handler
 */
abstract class Handler
{

    protected $logMessage = [];

    protected $logFormat = [
        'message' => '',    //message (mixed, can be a string or some complex data, such as an exception object)
        'level' => '',      //level (string)
        'timestamp' => '',  //timestamp (float, obtained by microtime(true))
        'category' => '',   //category (string)
        'trace' => '',      //traces (array, debug backtrace, contains the application code call stacks)
    ];

    protected $logType = [
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::DEBUG,
        LogLevel::EMERGENCY,
        LogLevel::ERROR,
        LogLevel::INFO,
        LogLevel::WARNING,
        LogLevel::NOTICE,
    ];

    /**
     * get formated time, Will output something like: 2014-01-01 12:20:24.423421
     *
     * @param string $format
     * @param int $utimestamp
     * @return bool|string
     */
    public function getLogTime(string $format = 'Y-m-d H:i:s', int $utimestamp = 0)
    {
        return date($format);
    }

    /**
     * checkout if the level input is alloawable
     *
     * @param string $level
     *
     * @return bool
     */
    public function checkLogLevel(string $level)
    {
        $return = in_array($level, $this->logType) ? true : false;

        return $return;
    }

    /**
     * handle a log info
     * @param string $level
     * @param string $message
     * @param array $context
     */
    public function handle(string $level, string $message, array $context = [])
    {
        if (empty($level) || empty($message)) {
            throw new \InvalidArgumentException('param error: level or message can\'t be empty');
        }
        if (!$this->checkLogLevel($level)) {
            return;
        }
        $logInfo = [
            'level' => $level,
            'message' => $message,
            'timestamp' => $this->getLogTime(),
            'category' => 'application',
        ];
        $logInfo = array_merge($logInfo, $context);
        $this->logMessage[] = $logInfo;
    }

}