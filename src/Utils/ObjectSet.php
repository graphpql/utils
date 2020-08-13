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
            $this->offsetSet(null, $object);
        }
    }

    public function toArray() : array
    {
        return $this->array;
    }

    public function merge(self $objectSet) : self
    {
        if (!$objectSet instanceof static) {
            throw new \Exception('I can only merge ObjectSets of same type');
        }

        foreach ($objectSet as $offset => $object) {
            $this->offsetSet($allowReplace
                ? $offset
                : null, $object);
        }

        return $this;
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

    public function offsetExists($offset) : bool
    {
        return \array_key_exists($offset, $this->array);
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
        if (!\is_a($object, static::INNER_CLASS)) {
            throw new \Exception('Invalid input.');
        }

        $key = $this->getKey($object);

        if ($offset === null) {
            if ($key === null) {
                $this->array[] = $object;

                return;
            }

            if ($this->offsetExists($key)) {
                throw new \Exception('Duplicated item. Set using explicit key if you wish to replace.');
            }

            $this->array[$key] = $object;
        }

        if (($key === null && \is_int($offset)) || (\is_string($key) && \is_string($offset))) {
            $this->array[$offset] = $object;

            return;
        }

        throw new \Exception('Invalid offset for given object.');
    }

    public function offsetUnset($offset) : void
    {
        if (!$this->offsetExists($offset)) {
            throw new \Exception('Item already doesnt exist.');
        }

        unset($this->array[$offset]);
    }

    protected function getKey(object $object) : ?string
    {
        return null;
    }
}
