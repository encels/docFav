<?php

namespace App\Domain\Event;

/**
 * Interface for a Domain Event.
 * 
 * A domain event represents something that has happened in the domain that you
 * want other parts of the system to be aware of. This interface ensures that
 * all domain events have a timestamp indicating when they occurred.
 */
interface DomainEvent
{
    /**
     * Gets the timestamp when the event occurred.
     * 
     * @return \DateTimeImmutable The date and time when the event occurred.
     */
    public function occurredOn(): \DateTimeImmutable;
}
