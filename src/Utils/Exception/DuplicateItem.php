<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class DuplicateItem extends \Exception
{
    public const MESSAGE = 'Duplicated item.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
