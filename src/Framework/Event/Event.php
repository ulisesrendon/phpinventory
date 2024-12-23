<?php

namespace Stradow\Framework\Event;

use Stradow\Framework\DependencyResolver\Container;
use Stradow\Framework\Event\Interface\StoppableEventInterface;

class Event
{
    /**
     * @template T of object
     *
     * @param T $Event
     * @return T
     */
    public static function dispatch(object $Event)
    {

        $Listeners = Container::get(ListenerProvider::class)->getListenersForEvent($Event);

        foreach ($Listeners as $Listener) {
            call_user_func($Listener, $Event);

            if ($Event instanceof StoppableEventInterface && $Event->isPropagationStopped()) {
                break;
            }
        }

        return $Event;
    }
}
