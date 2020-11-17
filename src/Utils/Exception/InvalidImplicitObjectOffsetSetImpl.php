<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class InvalidImplicitObjectOffsetSetImpl extends \Infinityloop\Utils\Exception\UtilsBase
{
    public const MESSAGE = 'Offset does not match implicit offset.';
}
