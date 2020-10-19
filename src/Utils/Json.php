<?php

declare(strict_types = 1);

namespace Infinityloop\Utils;

final class Json implements \Countable, \IteratorAggregate, \ArrayAccess, \Serializable
{
    use \Nette\SmartObject;

    private const FLAGS = \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_PRESERVE_ZERO_FRACTION;

    private ?string $string;
    private ?array $array;
    private bool $valid;

    private function __construct(?string $json, ?array $data)
    {
        $this->string = $json;
        $this->array = $data;
        $this->valid = false;
    }

    public static function fromString(string $json) : self
    {
        return new static($json, null);
    }

    public static function fromArray(array $data) : self
    {
        return new static(null, $data);
    }

    public function toString() : string
    {
        $this->loadString();

        return $this->string;
    }

    public function toArray() : array
    {
        $this->loadArray();

        return $this->array;
    }

    public function isValid() : bool
    {
        $this->loadString();
        $this->loadArray();

        return $this->valid;
    }

    public function count() : int
    {
        $this->loadArray();

        return \count($this->array);
    }

    public function getIterator() : \Iterator
    {
        $this->loadArray();

        return new \ArrayIterator($this->array);
    }

    public function offsetExists($offset) : bool
    {
        $this->loadArray();

        return \array_key_exists($offset, $this->array);
    }

    /** @return int|string|bool|array */
    public function offsetGet($offset)
    {
        $this->loadArray();

        return $this->array[$offset];
    }

    public function offsetSet($offset, $value) : void
    {
        $this->loadArray();
        $this->array[$offset] = $value;
        $this->string = null;
    }

    public function offsetUnset($offset) : void
    {
        $this->loadArray();
        unset($this->array[$offset]);
        $this->string = null;
    }

    public function serialize() : string
    {
        return $this->toString();
    }

    public function unserialize($serialized) : Json
    {
        return self::fromString($serialized);
    }

    private function loadString() : void
    {
        if (\is_string($this->string)) {
            return;
        }

        try {
            $this->string = \json_encode($this->array, self::FLAGS);
            $this->valid = true;
        } catch (\JsonException $exception) {
            $this->valid = false;
        }
    }

    private function loadArray() : void
    {
        if (\is_array($this->array)) {
            return;
        }

        try {
            $this->array = \json_decode($this->string, true, 512, self::FLAGS);
            $this->valid = true;
        } catch (\JsonException $exception) {
            $this->valid = false;
        }
    }

    public function __toString() : string
    {
        return $this->toString();
    }

    public function __isset($offset) : bool
    {
        return $this->offsetExists($offset);
    }

    /** @return int|string|bool|array */
    public function __get($offset)
    {
        return $this->offsetGet($offset);
    }

    public function __set($offset, $value) : void
    {
        $this->offsetSet($offset, $value);
    }

    public function __unset($offset) : void
    {
        $this->offsetUnset($offset);
    }
}
