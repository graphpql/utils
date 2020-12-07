<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class ImplicitOffsetDoesNotMatch extends \Exception
{
    public const MESSAGE = 'Given offset does not match with generated offset from getKey() function.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
