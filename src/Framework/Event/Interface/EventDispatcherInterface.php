<?php

namespace Stradow\Framework\Event\Interface;

interface EventDispatcherInterface
{
    /**
     * @template T of object
     *
     * @param  T  $Event
     * @return T
     */
    public static function dispatch(object $Event): object;
}
