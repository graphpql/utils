<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Json;

final class MapJson extends \Infinityloop\Utils\Json\JsonContract
{
    private ?string $string;
    private ?\stdClass $data;

    private function __construct(?string $json, ?\stdClass $data)
    {
        $this->string = $json;
        $this->data = $data;
    }

    public static function fromString(string $json) : static
    {
        return new self($json, null);
    }

    public static function fromNative(\stdClass $data) : self
    {
        return new self(null, $data);
    }

    public function toString() : string
    {
        $this->loadString();

        return $this->string;
    }

    public function toNative() : \stdClass
    {
        $this->loadObject();

        return $this->data;
    }

    public function count() : int
    {
        $this->loadObject();

        return \count((array) $this->data);
    }

    public function getIterator() : \Iterator
    {
        $this->loadObject();

        return new \ArrayIterator($this->data);
    }

    public function offsetExists($offset) : bool
    {
        $this->loadObject();

        return \property_exists($this->data, $offset);
    }

    public function offsetGet($offset) : int|string|float|bool|array|\stdClass|null
    {
        $this->loadObject();

        return $this->data->{$offset};
    }

    public function offsetSet($offset, $value) : void
    {
        $this->loadObject();
        $this->data->{$offset} = $value;
        $this->string = null;
    }

    public function offsetUnset($offset) : void
    {
        $this->loadObject();
        unset($this->data->{$offset});
        $this->string = null;
    }

    private function loadString() : void
    {
        if (\is_string($this->string)) {
            return;
        }

        $this->string = \json_encode(value: $this->data, flags: self::FLAGS);
    }

    private function loadObject() : void
    {
        if ($this->data instanceof \stdClass) {
            return;
        }

        $result = \json_decode(json: $this->string, associative: false, flags: self::FLAGS);

        if (!$result instanceof \stdClass) {
            throw new \RuntimeException('Required JSON object, got scalar or list.');
        }

        $this->data = $result;
    }
}
