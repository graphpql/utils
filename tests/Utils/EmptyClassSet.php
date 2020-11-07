<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

/**
 * @method \Infinityloop\Tests\Utils\EmptyClass current() : object
 * @method \Infinityloop\Tests\Utils\EmptyClass offsetGet($offset) : object
 */
final class EmptyClassSet extends \Infinityloop\Utils\ObjectSet
{
    protected const INNER_CLASS = EmptyClass::class;
}
