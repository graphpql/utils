<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class InvalidInput extends \Exception
{
    public const MESSAGE = 'Invalid input.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
