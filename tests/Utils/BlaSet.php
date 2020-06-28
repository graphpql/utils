<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

class BlaSet extends \Infinityloop\Utils\ObjectSet
{
    protected const INNER_CLASS = Bla::class;

    public function current() : Bla
    {
        return parent::current();
    }

    public function offsetGet($offset) : Bla
    {
        return parent::offsetGet($offset);
    }

    /** @return int|string|bool|object */
    protected function getKey($object)
    {
        return null;
    }
}
