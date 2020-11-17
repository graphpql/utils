<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class InvalidOffsetGet extends \Infinityloop\Utils\Exception\UtilsBase
{
    public const MESSAGE = 'Item doesnt exist.';
}
