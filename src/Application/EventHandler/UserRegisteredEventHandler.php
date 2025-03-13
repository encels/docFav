<?php

namespace App\Application\EventHandler;

use App\Domain\Event\UserRegisteredEvent;

/**
 * Event handler for the UserRegisteredEvent.
 * 
 * This class listens to the UserRegisteredEvent and simulates sending
 * a welcome email to the newly registered user.
 */
final class UserRegisteredEventHandler
{
    /**
     * Handles the UserRegisteredEvent.
     * 
     * Simulates sending a welcome email to the user when the event is triggered.
     * 
     * @param UserRegisteredEvent $event The event containing user data.
     * 
     * @return void
     */
    public function handle(UserRegisteredEvent $event): void
    {
        // Extract user data from the event
        $user = $event->user();
        $email = $user->email()->value();
        $name = $user->name()->value();
        $timestamp = $event->occurredOn()->format('Y-m-d H:i:s');

        try {
            // Simulate sending the email
            $this->simulateEmailSending($name, $email, $timestamp);

            // Log success
            error_log(sprintf(
                "Welcome email successfully simulated for %s (%s) at %s",
                $name,
                $email,
                $timestamp
            ));
        } catch (\Exception $e) {
            // Log failure
            error_log(sprintf(
                "Failed to simulate welcome email for %s (%s): %s",
                $name,
                $email,
                $e->getMessage()
            ));
        }
    }

    /**
     * Simulates the process of sending an email.
     * 
     * This method simply logs a message to simulate the email sending process.
     * 
     * @param string $name The name of the user.
     * @param string $email The email of the user.
     * @param string $timestamp The timestamp of when the event occurred.
     * 
     * @return void
     * 
     * @throws \Exception If an error occurs during the simulation.
     */
    private function simulateEmailSending(string $name, string $email, string $timestamp): void
    {
        // Simulate potential issues (optional)
        if (rand(1, 10) === 1) { // Simulate a 10% chance of failure
            throw new \Exception('Simulated email server error');
        }

        // Log the simulated email sending
        error_log(sprintf(
            "Simulating email to: %s (%s)\nSubject: Welcome to Our Platform!\nBody:\nHi %s,\n\nThank you for registering on our platform. We're excited to have you with us!\n\nSent at: %s",
            $name,
            $email,
            $name,
            $timestamp
        ));
    }
}
