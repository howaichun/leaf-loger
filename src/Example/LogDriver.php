<?php

/**
 * 这是一个驱动, 介绍了如何使用 leaf-loger, 向文件中写日志, 在实际应用场景中, 你可以自由发挥拓展, 而不是直接把当前这个这个driver
 * 拿到项目中使用
 * 另外, 该驱动实现了基本你可能需要的方法, 如日志记录 info, error, 以及获取文件处理器日志记录位置等
 * 本驱动主要做了3个事情
 * 1. 实例化loger, 该loger可做成单例模式, 是否单例取决于你, 本driver中, 并未处理成单例
 * 2. 实例化logHandlerManager, 并交给loger示例, 当然, 倘若你没有实例化这个 logHandlerManage 也可以, 因为loger内部已经做了这个事情
 * 3. 设置日志处理器, 比如文件处理器, 可设置多个, 设置完成后添加到 loger 中
 */

declare(strict_types = 1);

namespace Leaf\Loger\Example;

use \Psr\Log;
use \Leaf\Loger\Handler\HandlerFile;
use \Leaf\Loger\LogerClass\LogHandlerManager;
use \Leaf\Loger\Loger;

class LogDriver
{

    private static $instance = null;
    private $loger = null;

    private function __construct()
    {
        self::init();
    }

    private function init()
    {
        /**
         * 实例化loger
         */
        $this->loger = new Loger();;
        /**
         * 设置日志处理器之文件处理器
         */
        $fileHandler = new HandlerFile();
        /**
         * 将文件日志处理器添加到loger中
         */
        $this->getLoger()->addHandler('file', $fileHandler);
    }

    /**
     * 获取日志记录器
     * @return Loger
     */
    public function getLoger():Loger
    {
        return $this->loger;
    }

    /**
     * 获取单例模式实例化后的loger
     * @return Loger
     */
    public function getInstance(string $instanceName = 'default'):LogDriver
    {
        if (empty(self::$instance[$instanceName])) {
            self::$instance[$instanceName] = new self();
        }
        return self::$instance[$instanceName];
    }

    public function emergency(string $message, array $context = [])
    {
        $this->getLoger()->emergency($message, $context);
    }

    public function error(string $message, array $context = [])
    {
        $this->getLoger()->error($message, $context);
    }

    public function warning(string $message, array $context = [])
    {
        $this->getLoger()->warning($message, $context);
    }

    public function alert(string $message, array $context = [])
    {
        $this->getLoger()->alert($message, $context);
    }

    public function critical(string $message, array $context = [])
    {
        $this->getLoger()->critical($message, $context);
    }

    public function notice(string $message, array $context = [])
    {
        $this->getLoger()->notice($message, $context);
    }

    public function info(string $message, array $context = [])
    {
        $this->getLoger()->info($message, $context);
    }

    public function debug(string $message, array $context = [])
    {
        $this->getLoger()->debug($message, $context);
    }

    /**
     * 获取文件处理器日志记录路径
     */
    public function getLogFile()
    {
        $this->getLoger()->getLogHandlerManager()->getSomeLogHandler('file')->getLogFile();
    }

    /**
     * 设置文件处理器日志记录路径
     */
    public function setLogFile(string $file)
    {
        $this->getLoger()->getLogHandlerManager()->getSomeLogHandler('file')->setLogFile($file);
    }

}