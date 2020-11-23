<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

final class JsonTest extends \PHPUnit\Framework\TestCase
{
    public function testFromString() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}');

        self::assertSame('{"name":"Rosta"}', $instance->toString());
        self::assertSame(['name' => 'Rosta'], (array) $instance->toNative());
    }

    public function testFromStdClass() : void
    {
        $instance = \Infinityloop\Utils\Json::fromNative((object) ['name' => 'Rosta']);

        self::assertSame('{"name":"Rosta"}', $instance->toString());
        self::assertSame(['name' => 'Rosta'], (array) $instance->toNative());
    }

    public function testCount() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}');

        self::assertSame(1, $instance->count());
    }

    public function testGetIterator() : void
    {
        self::assertInstanceOf(
            \ArrayIterator::class,
            \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')->getIterator(),
        );
    }

    public function testOffsetExists() : void
    {
        self::assertTrue(\Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')->offsetExists('name'));
        self::assertArrayHasKey('name', \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}'));
        self::assertTrue(isset(\Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')->name));
    }

    public function testOffsetGet() : void
    {
        self::assertSame('Rosta', \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')->offsetGet('name'));
        self::assertSame('Rosta', \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')['name']);
        self::assertSame('Rosta', \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')->name);
    }

    public function testOffsetSet() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}');
        $instance->offsetSet('car', 'Tesla');

        self::assertTrue($instance->offsetExists('car'));
        self::assertSame('{"name":"Rosta","car":"Tesla"}', $instance->toString());

        $instance->car = 'Mercedes';

        self::assertTrue($instance->offsetExists('car'));
        self::assertSame('{"name":"Rosta","car":"Mercedes"}', $instance->toString());
    }

    public function testOffsetUnset() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}');

        self::assertTrue($instance->offsetExists('name'));

        $instance->offsetUnset('name');

        self::assertFalse($instance->offsetExists('name'));

        $instance->name = 'Rosta';

        self::assertTrue($instance->offsetExists('name'));

        unset($instance->name);

        self::assertFalse($instance->offsetExists('name'));
    }

    public function testMagicToString() : void
    {
        self::assertSame('{"name":"Rosta"}', \Infinityloop\Utils\Json::fromString('{"name":"Rosta"}')->__toString());
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

    public function testSequentialJson() : void
    {
        $instance = \Infinityloop\Utils\Json::fromString('[{"name":"Rosta"}, {"name":"Rosta"}, {"name":"Rosta"}]');

        self::assertCount(3, $instance);
        self::assertArrayHasKey(0, $instance);
        self::assertArrayHasKey(1, $instance);
        self::assertArrayHasKey(2, $instance);
        self::assertArrayNotHasKey(3, $instance);
        self::assertInstanceOf(\stdClass::class, $instance[0]);
        self::assertSame('Rosta', $instance[0]->name);
    }

    public function testDirectSequentialJson() : void
    {
        $instance = \Infinityloop\Utils\Json\SequentialJson::fromString('[{"name":"Rosta"}, {"name":"Rosta"}, {"name":"Rosta"}]');

        self::assertSame('[{"name":"Rosta"}, {"name":"Rosta"}, {"name":"Rosta"}]', $instance->toString());
        self::assertCount(3, $instance);
        self::assertArrayHasKey(0, $instance);
        self::assertArrayHasKey(1, $instance);
        self::assertArrayHasKey(2, $instance);
        self::assertArrayNotHasKey(3, $instance);
        self::assertInstanceOf(\stdClass::class, $instance[0]);
        self::assertSame('Rosta', $instance[0]->name);
    }

    public function testDirectMapJson() : void
    {
        $instance = \Infinityloop\Utils\Json\MapJson::fromString('{"name":"Rosta"}');

        self::assertSame('{"name":"Rosta"}', $instance->toString());
        self::assertInstanceOf(\stdClass::class, $instance);
        self::assertSame('Rosta', $instance->name);
    }

    public function testInvalidScalarJson() : void
    {
        $this->expectException(\RuntimeException::class);

        $instance = \Infinityloop\Utils\Json::fromString('"string json"');
        $instance->toNative();
    }

    public function testInvalidSequentialJson() : void
    {
        $this->expectException(\RuntimeException::class);

        \Infinityloop\Utils\Json::fromNative(['name' => 'Rosta']);
    }
}
