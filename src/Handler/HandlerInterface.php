<?php

declare(strict_types = 1);

namespace Leaf\Loger\Handler;

/**
 * Class HandlerFile
 * @package Leaf\Loger\Handler
 */

interface HandlerInterface
{

    public function handle(array $record = []);

}