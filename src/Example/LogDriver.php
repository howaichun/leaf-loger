<?php

/**
 * Leaf Loger
 * 此 driver 可以由
 */

declare(strict_types = 1);

namespace Leaf\Loger\Example;

use \Psr\Log;
use \Leaf\Loger\Handler\HandlerFile;
use \Leaf\Loger\LogerClass\LogHandlerManager;
use \Leaf\Loger\Loger;
use \Psr\Log\LoggerTrait;

class LogDriver extends LoggerTrait
{

    private static $instance = null;
    private static $loger = null;

    private function __construct()
    {
        /**
         * loger instance
         */
        $logManager = new LogHandlerManager();
        $loger = new Loger();
        $loger->setLogManager($logManager);
        static::$loger = $loger;
        /**
         * set a handler
         */
        $fileHandler = new HandlerFile();
        $fileHandler->setLogPath('./log.log');
        /**
         * add handler to loger
         */
        $loger->addHandler($fileHandler);
    }

    public static function getLoger():Loger
    {
        return static::$loger;
    }

    /**
     * 获取单例模式实例化后的loger
     * @return Loger
     */
    public static function getInstance():Loger
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function emergency(string $message, array $context = [])
    {
        static::getLoger()->emergency($message, $context);
    }

    public function error(string $message, array $context = [])
    {
        static::getLoger()->error($message, $context);
    }

    public function warning(string $message, array $context = [])
    {
        static::getLoger()->warning($message, $context);
    }

    public function alert(string $message, array $context = [])
    {
        static::getLoger()->alert($message, $context);
    }

    public function critical(string $message, array $context = [])
    {
        static::getLoger()->critical($message, $context);
    }

    public function notice(string $message, array $context = [])
    {
        static::getLoger()->notice($message, $context);
    }

    public function info(string $message, array $context = [])
    {
        static::getLoger()->info($message, $context);
    }

    public function debug(string $message, array $context = [])
    {
        static::getLoger()->debug($message, $context);
    }

    public function log(string $level, string $message, array $context = [])
    {
        static::getLoger()->log($level, $message, $context);
    }

}