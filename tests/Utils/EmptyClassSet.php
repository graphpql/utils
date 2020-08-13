<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

class EmptyClassSet extends \Infinityloop\Utils\ObjectSet
{
    protected const INNER_CLASS = EmptyClass::class;

    public function current() : EmptyClass
    {
        return parent::current();
    }

    public function offsetGet($offset) : EmptyClass
    {
        return parent::offsetGet($offset);
    }
}
