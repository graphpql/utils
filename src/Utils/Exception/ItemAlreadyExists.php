<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class ItemAlreadyExists extends \Exception
{
    public const MESSAGE = 'Item already exists, use $allowReplace if you wish to replace.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
