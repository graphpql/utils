<?php

declare(strict_types = 1);

namespace Infinityloop\Utils;

abstract class ObjectSet implements \Iterator, \ArrayAccess, \Countable
{
    use \Nette\SmartObject;

    protected const INNER_CLASS = self::class;

    protected array $array = [];

    public function __construct(array $data)
    {
        foreach ($data as $object) {
            if (!\is_a($object, static::INNER_CLASS)) {
                throw new \Exception('Invalid input.');
            }

            $key = $this->getKey($object);

            if ($key === null) {
                $this->array[] = $object;

                continue;
            }

            if ($this->offsetExists($key)) {
                throw new \Exception('Duplicated item.');
            }

            $this->array[$key] = $object;
        }
    }

    public function toArray() : array
    {
        return $this->array;
    }

    public function current() : object
    {
        return \current($this->array);
    }

    public function next() : void
    {
        \next($this->array);
    }

    /** @return int|string */
    public function key()
    {
        return \key($this->array);
    }

    public function valid() : bool
    {
        return \key($this->array) !== null;
    }

    public function rewind() : void
    {
        \reset($this->array);
    }

    public function count() : int
    {
        return \count($this->array);
    }

    public function offsetExists($name) : bool
    {
        return \array_key_exists($name, $this->array);
    }

    public function offsetGet($offset) : object
    {
        if (!$this->offsetExists($offset)) {
            throw new \Exception('Item doesnt exist.');
        }

        return $this->array[$offset];
    }

    public function offsetSet($offset, $object) : void
    {
        $key = $this->getKey($object);

        if ($key !== null && $key !== $offset) {
            throw new \Exception('Invalid offset for given object.');
        }

        $this->array[$offset] = $object;
    }

    public function offsetUnset($offset) : void
    {
        if (!$this->offsetExists($offset)) {
            throw new \Exception('Item already doesnt exist.');
        }

        unset($this->array[$offset]);
    }

    protected function getKey($object) : ?string
    {
        return null;
    }
}
