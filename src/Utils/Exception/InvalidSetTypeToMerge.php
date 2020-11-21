<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class InvalidSetTypeToMerge extends \Exception
{
    public const MESSAGE = 'I can only merge Sets of same type.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
