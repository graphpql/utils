<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class ImplicitOffsetDuplicated extends \Exception
{
    public const MESSAGE = 'This item already exists in Map, use explicit key if you wish to replace it.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
