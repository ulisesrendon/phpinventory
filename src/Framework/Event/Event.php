<?php
namespace App\Framework\Event;

use App\Framework\Event\ListenerProvider;
use App\Framework\DependencyResolver\Container;
use App\Framework\Event\Interfaces\StoppableEventInterface;

class Event
{

    /**
     * @template T
     * @param object<T> $Event
     * @return object<T>
     */
    public static function dispatch(object $Event)
    {

        $Listeners = Container::get(ListenerProvider::class)->getListenersForEvent($Event);

        foreach ($Listeners as $Listener) {
            call_user_func($Listener, $Event);
            
            if($Event instanceof StoppableEventInterface && $Event->isPropagationStopped()){
                break;
            }
        }

        return $Event;
    }
}