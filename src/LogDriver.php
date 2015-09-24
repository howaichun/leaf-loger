<?php

/**
 * Leaf Loger
 * 此 driver 可以由
 */

declare(strict_types = 1);

namespace Leaf\Loger;

use \Psr\Log;

class LogDriver extends \Psr\Log\LoggerTrait
{

    private static $instance = null;
    private static $loger = null;

    private function __construct()
    {
        //loger instance
        $logManager = new LogerClass\LogHandlerManager();
        $loger = new Loger();
        $loger->setLogManager($logManager);
        static::$loger = $loger;
        //set a handler
        $fileHandler = new Handler\HandlerFile();
        //add handler
        $loger->addHandler($fileHandler);
    }

    /**
     * 获取单例模式实例化后的loger
     * @return Loger
     */
    public static function getInstance(): Loger
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    public function emergency(string $message, array $context = [])
    {
        static::$loger->emergency($message, $context);
    }

    public function error(string $message, array $context = [])
    {
        static::$loger->error($message, $context);
    }

    public function warning(string $message, array $context = [])
    {
        static::$loger->warning($message, $context);
    }

    public function alert(string $message, array $context = [])
    {
        static::$loger->alert($message, $context);
    }

    public function critical(string $message, array $context = [])
    {
        static::$loger->critical($message, $context);
    }

    public function notice(string $message, array $context = [])
    {
        static::$loger->notice($message, $context);
    }

    public function info(string $message, array $context = [])
    {
        static::$loger->info($message, $context);
    }

    public function debug(string $message, array $context = [])
    {
        static::$loger->debug($message, $context);
    }

    public function log(string $level, string $message, array $context = [])
    {
        static::$loger->log($message, $context);
    }

}