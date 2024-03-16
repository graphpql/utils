<?php

declare(strict_types = 1);

namespace Infinityloop\Utils;

final class Json implements \Countable, \IteratorAggregate, \ArrayAccess, \Stringable
{
    private function __construct(
        private ?string $string,
        private ?array $data,
        private ?bool $isObject,
    )
    {
    }

    public static function fromNative(array|\stdClass $data) : self
    {
        if (\is_array($data) && (\count($data) === 0 || \array_is_list($data))) {
            return new self(null, $data, false);
        }

        return new self(null, (array) $data, true);
    }

    public static function fromString(string $json) : self
    {
        return new self($json, null, null);
    }

    public function toString() : string
    {
        $this->loadString();

        return $this->string;
    }

    public function toNative() : array|\stdClass
    {
        $this->loadInner();

        return $this->isObject
            ? (object) $this->data
            : $this->data;
    }

    public function count() : int
    {
        $this->loadInner();

        return \count($this->data);
    }

    public function getIterator() : \Traversable
    {
        $this->loadInner();

        return new \ArrayIterator($this->data);
    }

    public function offsetExists($offset) : bool
    {
        $this->loadInner();

        return \array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset) : int|string|float|bool|array|\stdClass|null
    {
        $this->loadInner();

        return $this->data[$offset];
    }

    public function offsetSet($offset, $value) : void
    {
        $this->loadInner();
        $this->data[$offset] = $value;
        $this->string = null;
    }

    public function offsetUnset($offset) : void
    {
        $this->loadInner();
        unset($this->data[$offset]);
        $this->string = null;
    }

    private function loadString() : void
    {
        if (\is_string($this->string)) {
            return;
        }

        $this->string = \json_encode(
            $this->data,
            flags: \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_PRESERVE_ZERO_FRACTION,
        );
    }

    private function loadInner() : void
    {
        if (\is_array($this->data) && \is_bool($this->isObject)) {
            return;
        }

        $result = \json_decode(
            json: $this->string,
            associative: false,
            flags: \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_PRESERVE_ZERO_FRACTION,
        );

        $this->isObject = match (true) {
            \is_array($result) => false,
            $result instanceof \stdClass => true,
            default => throw new \RuntimeException('Required JSON list or object, got scalar.')
        };
        $this->data = (array) $result;
    }

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
