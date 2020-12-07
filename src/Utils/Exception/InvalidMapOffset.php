<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class InvalidMapOffset extends \Exception
{
    public const MESSAGE = 'Invalid offset for map - expecting string.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
