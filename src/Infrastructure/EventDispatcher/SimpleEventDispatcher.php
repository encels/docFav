<?php

namespace App\Infrastructure\EventDispatcher;

use App\Domain\Event\DomainEvent;

/**
 * A simple event dispatcher that allows registering and dispatching domain events.
 */
class SimpleEventDispatcher
{
    /**
     * List of event listeners indexed by event class.
     *
     * @var array<string, callable[]>
     */
    private array $listeners = [];

    /**
     * Adds a listener for a specific event class.
     *
     * @param string   $eventClass The fully qualified class name of the event.
     * @param callable $listener   The listener to handle the event.
     *
     * @throws \InvalidArgumentException If the provided listener is not callable.
     */
    public function addListener(string $eventClass, callable $listener): void
    {
        if (!\is_callable($listener)) {
            throw new \InvalidArgumentException('The provided listener must be callable.');
        }

        $this->listeners[$eventClass][] = $listener;
    }

    /**
     * Dispatches an event to all registered listeners for its class.
     *
     * @param DomainEvent $event The event to dispatch.
     *
     * @return void
     */
    public function dispatch(DomainEvent $event): void
    {
        $eventClass = \get_class($event);

        if (empty($this->listeners[$eventClass])) {
            return;
        }

        foreach ($this->listeners[$eventClass] as $listener) {
            $listener($event);
        }
    }
}
