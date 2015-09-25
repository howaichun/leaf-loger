<?php

/**
 * Leaf Loger
 * 日志记录器
 * 强烈推荐使用[依赖注入方式, 如leaf-di]处理 loger、logHandlerManager、logHandler 三者之间的解耦合
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
     * @param LogHandlerManager $logHandlerManager
     */
    public function setLogHandlerManager(LogHandlerManager $logHandlerManager)
    {
        $this->logHandlerManager = $logHandlerManager;
    }

    /**
     * 获取 logHandlerManager
     * @return LogHandlerManager
     */
    public function getLogHandlerManager():LogHandlerManager
    {
        return $this->logHandlerManager;
    }

    /**
     * 获取日志记录处理器handler
     * 默认获取全部, 如果需要获取某个日志处理器, 则可以指定logHandlerName的名称
     * @param string $logHandlerName
     */
    public function getSomeLogHandler(string $logHandlerName)
    {
        if (empty($logHandlerName) && !is_null($this->logHandlerManager)) {
            return $this->getLogHandlerManager()->getSomeLogHandler($logHandlerName);
        }
    }

    /**
     * 系统不可用
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
     * **必须**立刻采取行动
     *
     * 例如：在整个网站都垮掉了、数据库不可用了或者其他的情况下，**应该**发送一条警报短信把你叫醒。
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
     * 紧急情况
     *
     * 例如：程序组件不可用或者出现非预期的异常。
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
     * 运行时出现的错误，不需要立刻采取行动，但必须记录下来以备检测。
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
     * 出现非错误性的异常。
     *
     * 例如：使用了被弃用的API、错误地使用了API或者非预想的不必要错误。
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
     * 一般性重要的事件。
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
     * 重要事件
     *
     * 例如：用户登录和SQL记录。
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
     * debug 详情
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
     * 任意等级的日志记录
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
     * 添加日志记录器
     * @param LogHandler $handler
     */
    public function addHandler(string $handlerName, Handler $handler)
    {
        static::getLogHandlerManager()->addHandler($handlerName, $handler);
    }

}