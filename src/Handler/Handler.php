<?php

declare(strict_types = 1);

namespace Leaf\Loger\Handler;

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

    abstract public function handle(string $level, string $message, array $context = []);

    /**
     * get formated time, Will output something like: 2014-01-01 12:20:24.423421
     * @param string $format
     * @param int $utimestamp
     * @return bool|string
     */
    public function getLogTime(string $format = 'Y-m-d H:i:s', int $utimestamp = 0)
    {
        return date($format);
    }
}