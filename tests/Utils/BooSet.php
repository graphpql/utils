<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

class BooSet extends \Infinityloop\Utils\ObjectSet
{
    protected const INNER_CLASS = Boo::class;

    protected function getKey($object) : string
    {
        return 'test';
    }
}
