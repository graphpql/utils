<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class MergeImplicitDuplicateItemError extends \Infinityloop\Utils\Exception\UtilsBase
{
    public const MESSAGE = 'Item already exists, use $allowReplace if you wish to replace.';
}
