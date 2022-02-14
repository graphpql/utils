<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Json;

abstract class JsonContract implements \Countable, \IteratorAggregate, \ArrayAccess, \Stringable
{
    use \Nette\SmartObject;

    protected const FLAGS = \JSON_THROW_ON_ERROR
        | \JSON_UNESCAPED_UNICODE
        | \JSON_UNESCAPED_SLASHES
        | \JSON_PRESERVE_ZERO_FRACTION;

    abstract public static function fromString(string $json) : static;

    abstract public function toString() : string;

    abstract public function toNative() : array|\stdClass;

    public function __toString() : string
    {
        return $this->toString();
    }

    public function __isset($name) : bool
    {
        return $this->offsetExists($name);
    }

    public function __get($name) : int|string|float|bool|array|\stdClass|null
    {
        return $this->offsetGet($name);
    }

    public function __set($name, $value) : void
    {
        $this->offsetSet($name, $value);
    }

    public function __unset($name) : void
    {
        $this->offsetUnset($name);
    }
}
