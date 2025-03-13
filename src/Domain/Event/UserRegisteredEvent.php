<?php

namespace App\Domain\Event;

use App\Domain\Model\User\User;

/**
 * Event triggered when a new user is registered.
 * 
 * This domain event represents the action of a user being registered in the system.
 * It encapsulates the user entity and the timestamp of when the event occurred.
 */
final class UserRegisteredEvent implements DomainEvent
{
    /**
     * @var User The registered user.
     */
    private User $user;

    /**
     * @var \DateTimeImmutable The date and time when the event occurred.
     */
    private \DateTimeImmutable $occurredOn;

    /**
     * UserRegisteredEvent constructor.
     * 
     * @param User $user The user entity associated with this event.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->occurredOn = new \DateTimeImmutable();
    }

    /**
     * Gets the user associated with this event.
     * 
     * @return User The registered user.
     */
    public function user(): User
    {
        return $this->user;
    }

    /**
     * Gets the timestamp when the event occurred.
     * 
     * @return \DateTimeImmutable The date and time when the event occurred.
     */
    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
