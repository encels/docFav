<?php

namespace App\Domain\Exception;

use InvalidArgumentException;

/**
 * Exception thrown when a password does not meet the required strength.
 */
final class WeakPasswordException extends InvalidArgumentException {}
