<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

final class JsonTest extends \PHPUnit\Framework\TestCase
{
    public function testFromString() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}');

        self::assertSame('{"name":"Rosta"}', $instance->toString());
        self::assertSame(['name' => 'Rosta'], $instance->toArray());
    }

    public function testFromArray() : void
    {
        $instance = \Infinityloop\Utils\Json::fromArray(['name' => 'Rosta']);

        self::assertSame('{"name":"Rosta"}', $instance->toString());
        self::assertSame(['name' => 'Rosta'], $instance->toArray());
    }

    public function testLoadArrayInvalidInput() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('{name: Rosta}');

        self::assertFalse($instance->isValid());
    }

    public function testLoadStringInvalidInput() : void
    {
        $instance = \Infinityloop\Utils\Json::fromArray(['name' => " \xB1\x31"]);

        self::assertFalse($instance->isValid());
    }

    public function testIsValid() : void
    {
        $check = \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')->isValid()
            && \Infinityloop\Utils\Json::fromArray(['name' => 'Rosta'])->isValid();

        self::assertEquals(true, $check);
    }

    public function testCount() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}');

        self::assertSame(1, $instance->count());
        self::assertCount($instance->count(), $instance->toArray());
    }

    public function testGetIterator() : void
    {
        self::assertInstanceOf('\ArrayIterator', \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')->getIterator());
    }

    public function testOffsetExists() : void
    {
        self::assertSame(true, \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')->offsetExists('name'));
    }

    public function testOffsetGet() : void
    {
        self::assertSame('Rosta', \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')->offsetGet('name'));
    }

    public function testOffsetSet() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}');
        $instance->offsetSet('car', 'Tesla');

        self::assertSame('{"name":"Rosta","car":"Tesla"}', $instance->toString());
        self::assertTrue($instance->offsetExists('car'));
    }

    public function testOffsetUnset() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}');
        $instance->offsetUnset('name');

        self::assertSame(false, $instance->offsetExists('name'));
    }

    public function testSerialize() : void
    {
        self::assertSame('{"name":"Rosta"}', \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')->serialize());
    }

    public function testUnserialize() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}');
        $instance->unserialize('{"name":"Rosta"}');

        self::assertSame('{"name":"Rosta"}', $instance->toString());
    }

    public function testMagicToString() : void
    {
        self::assertSame('{"name":"Rosta"}', \Infinityloop\Utils\Json::fromArray(['name' => 'Rosta'])->__toString());
    }

    public function testMagicIsset() : void
    {
        self::assertSame(true, \Infinityloop\Utils\Json::fromArray(['name' => 'Rosta'])->__isset('name'));
    }

    public function testMagicGet() : void
    {
        self::assertSame('Rosta', \Infinityloop\Utils\Json::fromArray(['name' => 'Rosta'])->__get('name'));
    }

    public function testMagicSet() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}');
        $instance->__set('car', 'Tesla');

        self::assertTrue($instance->offsetExists('car'));
    }

    public function testMagicUnset() : void
    {
        $instance = \Infinityloop\Utils\Json::fromArray(['name' => 'Rosta']);
        $instance->__unset('name');

        self::assertSame(false, $instance->offsetExists('name'));
    }
}
