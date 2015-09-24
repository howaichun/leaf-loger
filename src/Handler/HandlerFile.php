<?php

declare(strict_types = 1);

namespace Leaf\Loger\Handler;

/**
 * file handler
 * Class HandlerFile
 * @package Leaf\Loger\Handler
 */
class HandlerFile implements HandlerInterface
{

    protected $logContent = '';
    protected $logFile = '';
    protected $maxFileSize = '20k';
    protected $maxLogFiles = 1000;

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

    /**
     * register a shutdown function so that we can flush log string to file once
     */
    protected function registerFileLogShutDown()
    {
        register_shutdown_function([$this, 'flushLog']);
    }

    public function flushLog()
    {

    }

    public function handle(array $record = [])
    {

    }


}