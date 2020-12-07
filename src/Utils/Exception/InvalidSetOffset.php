<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class InvalidSetOffset extends \Exception
{
    public const MESSAGE = 'Invalid offset for set - expecting int or null.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
