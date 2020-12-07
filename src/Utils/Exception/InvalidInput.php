<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class InvalidInput extends \Exception
{
    public const MESSAGE = 'Invalid item given for a class, expected instanceof %s.';

    public function __construct(string $className)
    {
        parent::__construct(\sprintf(self::MESSAGE, $className));
    }
}
