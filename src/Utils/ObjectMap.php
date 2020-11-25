<?php

declare(strict_types = 1);

namespace Infinityloop\Utils;

abstract class ObjectMap extends \Infinityloop\Utils\BaseSet
{
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $object) {
            $this->offsetSet($key, $object);
        }
    }

    public function key() : string
    {
        return \key($this->array);
    }

    protected function mergeImpl(BaseSet $objectSet, bool $allowReplace = false) : static
    {
        foreach ($objectSet as $offset => $object) {
            if (!$allowReplace && $this->offsetExists($offset)) {
                throw new \Exception('Item already exists, use $allowReplace if you wish to replace');
            }

            $this->offsetSet($offset, $object);
        }

        return $this;
    }

    protected function offsetSetImpl($offset, object $object) : void
    {
        if (\is_string($offset)) {
            $this->array[$offset] = $object;

            return;
        }

        throw new \Exception('Invalid offset for given object.');
    }
}
