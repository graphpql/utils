<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class SetsTypeMergeError extends \Infinityloop\Utils\Exception\UtilsBase
{
    public const MESSAGE = 'I can only merge Sets of same type.';
}
