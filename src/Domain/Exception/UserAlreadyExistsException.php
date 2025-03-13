<?php

namespace App\Domain\Exception;

use Exception;

/**
 * Exception thrown when attempting to create a user that already exists.
 */
final class UserAlreadyExistsException extends Exception {}
