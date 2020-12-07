<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class InvalidTypeToMerge extends \Exception
{
    public const MESSAGE = 'Merged sets must be of the same type.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
