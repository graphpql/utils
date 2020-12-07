<?php

declare(strict_types = 1);

namespace Infinityloop\Utils;

abstract class ImplicitObjectMap extends \Infinityloop\Utils\ObjectMap
{
    public function __construct(array $data = [])
    {
        parent::__construct();

        foreach ($data as $key => $object) {
            $this->offsetSet(
                \is_string($key)
                    ? $key
                    : null,
                $object,
            );
        }
    }

    abstract protected function getKey(object $object) : string;

    protected function offsetSetImpl($offset, object $object) : void
    {
        $key = $this->getKey($object);

        if ($offset === $key) {
            parent::offsetSetImpl($key, $object);

            return;
        }

        if ($offset === null) {
            if ($this->offsetExists($key)) {
                throw new \Infinityloop\Utils\Exception\ImplicitOffsetDuplicated();
            }

            parent::offsetSetImpl($key, $object);

            return;
        }

        throw new \Infinityloop\Utils\Exception\ImplicitOffsetDoesNotMatch();
    }
}
