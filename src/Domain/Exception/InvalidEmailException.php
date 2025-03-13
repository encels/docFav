<?php

namespace App\Domain\Exception;

use InvalidArgumentException;

/**
 * Exception thrown when an invalid email address is provided.
 */
final class InvalidEmailException extends InvalidArgumentException {}
