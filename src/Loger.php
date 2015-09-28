<?php

/**
 * loger
 * you are recommend to handle loger,logHandlerManager and logHandler with dependent object such as leaf-di to loose coupling.
 */

declare(strict_types = 1);

namespace Leaf\Loger;

use Leaf\Loger\Handler\Handler;
use Leaf\Loger\LogerClass\LogHandlerManager;
use Leaf\Loger\LogerClass\LogLevel;

//use Psr\Log\AbstractLogger;
//class Loger extends AbstractLogger

class Loger
{

    protected $logHandlerManager = null;

    public function __construct()
    {
        $this->init();
    }

    /**
     * init
     */
    public function init()
    {
        $logHandlerManager = new LogHandlerManager();
        $this->setLogHandlerManager($logHandlerManager);
    }

    /**
     * set logHandlerManager to this loger
     *
     * @param LogHandlerManager $logHandlerManager
     */
    public function setLogHandlerManager(LogHandlerManager $logHandlerManager)
    {
        $this->logHandlerManager = $logHandlerManager;
    }

    /**
     * get the logHandlerManager
     *
     * @return LogHandlerManager
     */
    public function getLogHandlerManager():LogHandlerManager
    {
        return $this->logHandlerManager;
    }

    /**
     * get a log handler with it's name
     *
     * @param string $logHandlerName
     */
    public function getSomeLogHandler(string $logHandlerName)
    {
        if (empty($logHandlerName) && !is_null($this->logHandlerManager)) {
            return $this->getLogHandlerManager()->getSomeLogHandler($logHandlerName);
        }
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency(string $message, array $context = [])
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function alert(string $message, array $context = [])
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function critical(string $message, array $context = [])
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function error(string $message, array $context = [])
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function warning(string $message, array $context = [])
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function notice(string $message, array $context = [])
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * important log
     *
     * sush as：login in log and SQL log。
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function info(string $message, array $context = [])
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * debug log
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function debug(string $message, array $context = [])
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * log
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log(string $level, string $message, array $context = [])
    {
        if (is_object(static::getLogHandlerManager()) && (static::getLogHandlerManager() instanceof LogHandlerManager)) {
            static::getLogHandlerManager()->handle($level, $message, $context);
        } else {
            throw new \UnexpectedValueException('logManager needed!');
        }
    }

    /**
     * add a log handler
     * @param LogHandler $handler
     */
    public function addHandler(string $handlerName, Handler $handler)
    {
        static::getLogHandlerManager()->addHandler($handlerName, $handler);
    }

}