<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

final class NamedClassSet extends \Infinityloop\Utils\ObjectSet
{
    protected const INNER_CLASS = NamedClass::class;

    public function current() : NamedClass
    {
        return parent::current();
    }

    public function offsetGet($offset) : NamedClass
    {
        return parent::offsetGet($offset);
    }

    protected function getKey($object) : string
    {
        return $object->name;
    }
}
