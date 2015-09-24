<?php

declare(strict_types = 1);

namespace Leaf\Loger\LogerClass;

use Leaf\Loger\Loger;


/**
 * Class LogerManager
 * @package Leaf\Loger\LogerClas
 */
class LogHandlerManager
{

    /**
     * instances of log handler objects such as fileHandler
     * @var array
     */
    protected $handlers = [];

    public function __construct()
    {
    }

    /**
     * @param string $handlerName
     * @param LogHandler $handler
     */
    public function addHandler(string $handlerName, Loger $handler)
    {
        if (empty($handlerName) || empty($handler)) {
            throw new \InvalidArgumentException('handlerName or handler can\'t be empty');
        }
        $this->handlers[$handlerName] = $handler;
    }

    /**
     * remove log handler
     * @param string $handlerName
     * @return bool
     */
    public function removeHandler(string $handlerName): bool
    {
        $removed = false;
        if (empty($handlerName)) {
            throw new \InvalidArgumentException('handlerName can\'t be empty');
        }
        if (isset($this->handlers[$handlerName])) {
            unset($this->handlers[$handlerName]);
            $removed = true;
        }
        return $removed;
    }

    /**
     * handle log info
     * @param string $level
     * @param string $message
     * @param array $context
     */
    public function handle(string $level, string $message, array $context = [])
    {
        foreach ($this->handlers as $handlerObj) {
            $handlerObj->handle($level, $message, $context);
        }
    }

}