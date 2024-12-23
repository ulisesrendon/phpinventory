<?php

namespace Stradow\Framework\Event;

use Stradow\Framework\Event\Interface\StoppableEventInterface;

class StoppableEvent implements StoppableEventInterface
{
    public bool $PropagationStopped = false;

    public function isPropagationStopped(): bool
    {
        return $this->PropagationStopped;
    }

    public function stopPropagation()
    {
        $this->PropagationStopped = true;
    }
}
