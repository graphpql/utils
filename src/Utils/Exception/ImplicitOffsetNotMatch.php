<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

final class ImplicitOffsetNotMatch extends \Exception
{
    public const MESSAGE = 'Offset does not match implicit offset.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
