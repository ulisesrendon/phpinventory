<?php
namespace App\Order\Event;

use App\Framework\Event\Interfaces\StoppableEventInterface;

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