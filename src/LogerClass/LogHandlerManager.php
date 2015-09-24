<?php

declare(strict_types = 1);

namespace Leaf\Loger\LogerClass;

/**
 * Class LogerManager
 * @package Leaf\Loger\LogerClas
 */
class LogHandlerManager
{

    protected $handlers = [];

    public function __construct()
    {
    }

    /**
     * @param \Leaf\Loger\LogerClass\LogHandler $handler
     */
    public function addHandler(LogHandler $handler)
    {

    }

    public function removeHandler()
    {

    }

    public function handle(string $level, string $message, array $context = [])
    {

    }

}