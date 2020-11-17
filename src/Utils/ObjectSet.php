<?php

declare(strict_types = 1);

namespace Infinityloop\Utils;

abstract class ObjectSet extends \Infinityloop\Utils\BaseSet
{
    public function __construct(array $data = [])
    {
        foreach ($data as $object) {
            $this->offsetSet(null, $object);
        }
    }

    public function key() : int
    {
        return \key($this->array);
    }

    protected function mergeImpl(BaseSet $objectSet, bool $allowReplace = false) : self
    {
        foreach ($objectSet as $offset => $object) {
            $this->offsetSet($allowReplace
                ? $offset
                : null, $object);
        }

        return $this;
    }

    protected function offsetSetImpl($offset, object $object) : void
    {
        if ($offset === null) {
            $this->array[] = $object;

            return;
        }

        if (\is_int($offset)) {
            $this->array[$offset] = $object;

            return;
        }

        throw new \Infinityloop\Utils\Exception\InvalidObjectOffsetSetImpl();
    }
}
