<?php
namespace App\Framework\Event;

use App\Framework\Event\Interfaces\ListenerProviderInterface;

class ListenerProvider implements ListenerProviderInterface
{
    /**
     * Summary of listeners
     * @var array<class-string, list<callable()>>
     */
    protected array $listeners;
    
    public function  __construct(array $listeners = [])
    {
        $this->listeners = $listeners;
    }

    /**
     * Summary of getListenersForEvent
     * @template T
     * @param T $Event
     * @return iterable<callable>
     */
    public function getListenersForEvent(object $Event): iterable
    {
        return $this->listeners[$Event::class] ?? [];
    }
}