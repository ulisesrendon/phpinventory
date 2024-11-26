<?php

namespace Stradow\Framework\Event;

use Stradow\Framework\DependencyResolver\Container;
use Stradow\Framework\Event\Interfaces\StoppableEventInterface;

class Event
{
    /**
     * @template T
     *
     * @param  object<T>  $Event
     * @return object<T>
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
