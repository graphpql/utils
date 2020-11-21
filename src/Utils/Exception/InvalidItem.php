<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class InvalidItem extends \Exception
{
    public const MESSAGE = 'Item doesnt exist.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
