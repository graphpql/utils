<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class InvalidObjectOffset extends \Exception
{
    public const MESSAGE = 'Invalid offset for given object.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
