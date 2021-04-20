<?php

declare(strict_types = 1);

namespace Infinityloop\Utils;

abstract class BaseSet implements \Iterator, \ArrayAccess, \Countable
{
    use \Nette\SmartObject;

    protected const INNER_CLASS = self::class;
    protected const EXCEPTION_UNKNOWN_OFFSET = \Infinityloop\Utils\Exception\UnknownOffset::class;

    protected array $array = [];

    public function merge(self $objectSet, bool $allowReplace = false) : static
    {
        if (!$objectSet instanceof static) {
            throw new \Infinityloop\Utils\Exception\InvalidTypeToMerge();
        }

        return $this->mergeImpl($objectSet, $allowReplace);
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
            $exception = static::EXCEPTION_UNKNOWN_OFFSET;

            throw new $exception($offset);
        }

        return $this->array[$offset];
    }

    public function offsetSet($offset, $value) : void
    {
        if (!\is_a($value, static::INNER_CLASS)) {
            throw new \Infinityloop\Utils\Exception\InvalidInput(static::INNER_CLASS);
        }

        $this->offsetSetImpl($offset, $value);
    }

    public function offsetUnset($offset) : void
    {
        if (!$this->offsetExists($offset)) {
            $exception = static::EXCEPTION_UNKNOWN_OFFSET;

            throw new $exception($offset);
        }

        unset($this->array[$offset]);
    }
    
    public function __clone() : void
    {
        $newArray = [];
        
        foreach ($this as $key => $object) {
            $newArray[$key] = clone $object;
        }
        
        $this->array = $newArray;
    }

    abstract protected function mergeImpl(self $objectSet, bool $allowReplace) : static;

    abstract protected function offsetSetImpl($offset, object $object) : void;
}
