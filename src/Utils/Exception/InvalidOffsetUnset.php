<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class InvalidOffsetUnset extends \Infinityloop\Utils\Exception\UtilsBase
{
    public const MESSAGE = 'Item already doesnt exist.';
}
