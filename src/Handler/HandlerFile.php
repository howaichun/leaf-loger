<?php

declare(strict_types = 1);

namespace Leaf\Loger\Handler;

/**
 * file handler
 * Class HandlerFile
 * @package Leaf\Loger\Handler
 */
class HandlerFile extends Handler
{

    protected $logContent = '';
    protected $logFile = '';
    protected $maxFileSize = 0; //文件大小分割标识, 0表示不分割, 10 * 1024 表示以10M来分割文件
    protected $logMessageFormat = '<timestamp> [-][-][-][<level>][<category>] <message>';

    /**
     * 文件日志处理器初始化
     */
    public function __construct()
    {
        //class init
        $this->init();
    }

    /**
     * set log file
     * @param string $file
     */
    public function setLogFile(string $file)
    {
        if (!empty($file)) {
            $this->logFile = $file;
            $this->makeLogFile();
        } else {
            throw new \InvalidArgumentException('you can\'t set empty log path');
        }
    }

    /**
     * 设置logFile的时候, 如果logFile目标文件不存在,则创建
     * @throws \Exception
     */
    protected function makeLogFile()
    {
        try {
            if (!empty($this->logFile)) {
                //create dir and file
                if (!is_dir($logDir = dirname($this->logFile))) {
                    mkdir($logDir, 0777, true);
                    touch($this->logFile);
                }
                if (!is_file($this->logFile)) {
                    touch($this->logFile);
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 获取日志文件磁盘地址
     * @return string
     */
    public function getLogFile()
    {
        return $this->logFile;
    }

    /**
     * 初始化操作
     */
    public function init()
    {
        $this->registerFileLogShutDown();
    }

    /**
     * 设置 日志格式
     * @param string $format 如: '<timestamp> [-][-][-][<level>][<category>] <message>';
     */
    public function setLogMessageFormat(string $format)
    {
        $this->logMessageFormat = $format;
    }

    /**
     * 注册一个shutdown函数, 当程序结束的时候, 将日志一次性刷入文件中
     */
    protected function registerFileLogShutDown()
    {
        register_shutdown_function([$this, 'flushLog']);
    }

    /**
     * 获取日志内容,并刷入文件中
     */
    public function flushLog()
    {
        if (!empty($this->logMessage)) {
            foreach ($this->logMessage as $message) {
                $this->logContent .= $this->pregLogContent($message) . PHP_EOL;
            }
            $this->flushToFile();
        }
    }

    /**
     * 根据 $this->logMessageFormat 日志文件格式, 将数组形式的日志内容格式化为字符串内容
     * @param array $message
     * @return string
     */
    protected function pregLogContent(array $message = []):string
    {
        $messageStr = '';
        $replaceSearch = [];
        $replaceContent = [];
        foreach ($message as $messageKey => $messageVal) {
            $replaceSearch[] = '<' . $messageKey . '>';
            $replaceContent[] = $messageVal;
        }
        $messageStr = str_replace($replaceSearch, $replaceContent, $this->logMessageFormat);
        return $messageStr;
    }

    /**
     * 将日志内容写入文件
     */
    protected function flushToFile()
    {
        if ($this->maxFileSize === 0) {
            error_log($this->logContent, 3, $this->logFile);
        }
    }

    /**
     * 处理日志信息, 将所有日志内容, 放入日志内容的数组中
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
        $logInfo = array_merge($logInfo, $context);
        $this->logMessage[] = $logInfo;
    }


}