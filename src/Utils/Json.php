<?php

declare(strict_types = 1);

namespace Infinityloop\Utils;

final class Json extends \Infinityloop\Utils\Json\JsonContract
{
    private ?string $string;
    private ?\Infinityloop\Utils\Json\JsonContract $inner;

    private function __construct(?string $json, ?\Infinityloop\Utils\Json\JsonContract $data)
    {
        $this->string = $json;
        $this->inner = $data;
    }

    public static function fromString(string $json) : static
    {
        return new self($json, null);
    }

    public static function fromNative(array|\stdClass $data) : self
    {
        if (\is_array($data)) {
            return new self(null, \Infinityloop\Utils\Json\SequentialJson::fromNative($data));
        }

        return new self(null, \Infinityloop\Utils\Json\MapJson::fromNative($data));
    }

    public function toString() : string
    {
        $this->loadString();

        return $this->string;
    }

    public function toNative() : array|\stdClass
    {
        $this->loadInner();

        return $this->inner->toNative();
    }

    public function count() : int
    {
        $this->loadInner();

        return $this->inner->count();
    }

    public function getIterator() : \Traversable
    {
        $this->loadInner();

        return $this->inner->getIterator();
    }

    public function offsetExists($offset) : bool
    {
        $this->loadInner();

        return $this->inner->offsetExists($offset);
    }

    public function offsetGet($offset) : int|string|float|bool|array|\stdClass|null
    {
        $this->loadInner();

        return $this->inner->offsetGet($offset);
    }

    public function offsetSet($offset, $value) : void
    {
        $this->loadInner();
        $this->inner->offsetSet($offset, $value);
        $this->string = null;
    }

    public function offsetUnset($offset) : void
    {
        $this->loadInner();
        $this->inner->offsetUnset($offset);
        $this->string = null;
    }

    private function loadString() : void
    {
        if (\is_string($this->string)) {
            return;
        }

        $this->string = $this->inner->toString();
    }

    private function loadInner() : void
    {
        if ($this->inner instanceof \Infinityloop\Utils\Json\JsonContract) {
            return;
        }

        $result = \json_decode(json: $this->string, associative: false, flags: self::FLAGS);

        if (\is_array($result)) {
            $this->inner = \Infinityloop\Utils\Json\SequentialJson::fromNative($result);

            return;
        }

        if ($result instanceof \stdClass) {
            $this->inner = \Infinityloop\Utils\Json\MapJson::fromNative($result);

            return;
        }

        throw new \RuntimeException('Required JSON list or object, got scalar.');
    }
}
