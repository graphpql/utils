<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class ItemDoesntExist extends \Exception
{
    public const MESSAGE = 'Item already doesnt exist.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
