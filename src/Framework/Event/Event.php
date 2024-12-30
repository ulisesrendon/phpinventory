<?php

namespace Stradow\Framework\Event;

use Stradow\Framework\DependencyResolver\Container;
use Stradow\Framework\Event\Interface\StoppableEventInterface;
use Stradow\Framework\Event\Interface\ListenerProviderInterface;

class Event
{
    public ListenerProviderInterface $ListenerProvider;

    public function __construct(ListenerProviderInterface $ListenerProvider)
    {
        $this->ListenerProvider = $ListenerProvider;
    }

    /**
     * @template T of object
     *
     * @param  T  $Event
     * @return T
     */
    public function dispatch(object $Event)
    {

        $Listeners = $this->ListenerProvider->getListenersForEvent($Event);

        foreach ($Listeners as $Listener) {
            call_user_func($Listener, $Event);

            if ($Event instanceof StoppableEventInterface && $Event->isPropagationStopped()) {
                break;
            }
        }

        return $Event;
    }
}
