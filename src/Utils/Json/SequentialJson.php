<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Json;

final class SequentialJson extends \Infinityloop\Utils\Json\JsonContract
{
    private ?string $string;

    private function __construct(
        ?string $json,
        private ?array $data,
    )
    {
        if (\is_array($data) && \array_key_first($data) !== 0) {
            throw new \RuntimeException('Associative array detected, use MapJson instead.');
        }

        $this->string = $json;
    }

    public static function fromNative(array $data) : self
    {
        return new self(null, $data);
    }

    public static function fromString(string $json) : static
    {
        return new self($json, null);
    }

    public function toString() : string
    {
        $this->loadString();

        return $this->string;
    }

    public function toNative() : array
    {
        $this->loadArray();

        return $this->data;
    }

    public function count() : int
    {
        $this->loadArray();

        return \count($this->data);
    }

    public function getIterator() : \Iterator
    {
        $this->loadArray();

        return new \ArrayIterator($this->data);
    }

    public function offsetExists($offset) : bool
    {
        $this->loadArray();

        return \array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset) : int|string|float|bool|array|\stdClass|null
    {
        $this->loadArray();

        return $this->data[$offset];
    }

    public function offsetSet($offset, $value) : void
    {
        $this->loadArray();
        $this->data[$offset] = $value;
        $this->string = null;
    }

    public function offsetUnset($offset) : void
    {
        $this->loadArray();
        unset($this->data[$offset]);
        $this->string = null;
    }

    private function loadString() : void
    {
        if (\is_string($this->string)) {
            return;
        }

        $this->string = \json_encode(value: $this->data, flags: self::FLAGS);
    }

    private function loadArray() : void
    {
        if (\is_array($this->data)) {
            return;
        }

        $result = \json_decode(json: $this->string, associative: false, flags: self::FLAGS);

        if (!\is_array($result)) {
            throw new \RuntimeException('Required JSON list, got scalar or object.');
        }

        $this->data = $result;
    }
}
