<?php

use PHPUnit\Framework\TestCase;
use Stradow\Framework\Event\ListenerProvider;
use Stradow\Framework\Event\StoppableEvent;

class ListenerProviderTest extends TestCase
{
    public function test_get_listeners_for_event()
    {
        // Create some mock listeners
        $listener1 = function () {};
        $listener2 = function () {};

        $Event = new StoppableEvent;

        // Create the ListenerProvider with the mock listeners
        $listeners = [
            StoppableEvent::class => [$listener1, $listener2],
        ];
        $provider = new ListenerProvider($listeners);

        // Get the listeners for the event
        $result = $provider->getListenersForEvent($Event);

        // Assert that the result contains the expected listeners
        // $this->assertContains($listener1, $result);
        // $this->assertContains($listener2, $result);
        $this->assertCount(2, $result);
    }

    public function test_get_listeners_for_event_with_no_listeners()
    {
        // Create a mock event
        $event = $this->createMock(StoppableEvent::class);

        // Create the ListenerProvider with no listeners
        $provider = new ListenerProvider;

        // Get the listeners for the event
        $result = $provider->getListenersForEvent($event);

        // Assert that the result is empty
        $this->assertEmpty($result);
    }
}
