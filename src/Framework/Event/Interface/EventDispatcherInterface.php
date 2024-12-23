<?php
namespace Stradow\Framework\Event\Interface;

interface EventDispatcherInterface
{
    /**
     * @template T
     *
     * @param object<T> $Event
     * @return object<T>
     */
    public static function dispatch(object $Event): object;
}