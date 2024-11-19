<?php

namespace App\Shared\Infrastructure\Persistence\Exceptions;

use RuntimeException;

class StaleModelLockingException extends RuntimeException {}
