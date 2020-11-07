<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

/**
 * @method \Infinityloop\Tests\Utils\NamedClass current() : object
 * @method \Infinityloop\Tests\Utils\NamedClass offsetGet($offset) : object
 */
final class ImplicitNamedClassSet extends \Infinityloop\Utils\ImplicitObjectMap
{
    protected const INNER_CLASS = NamedClass::class;

    protected function getKey(object $object) : string
    {
        return $object->name;
    }
}
