<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

final class ObjectSetTest extends \PHPUnit\Framework\TestCase
{
    public function testToArray() : void
    {
        $array = (new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
        ]))->toArray();

        self::assertCount(2, $array);
        self::assertArrayHasKey(0, $array);
        self::assertArrayHasKey(1, $array);
    }

    public function testIterator() : void
    {
        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
        ]);

        $index = 0;

        foreach ($instance as $key => $value) {
            self::assertSame($index, $key);
            self::assertInstanceOf(EmptyClass::class, $value);

            ++$index;
        }

        $index = 0;

        foreach ($instance as $key => $value) {
            self::assertSame($index, $key);
            self::assertInstanceOf(EmptyClass::class, $value);

            ++$index;
        }
    }

    public function testCount() : void
    {
        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
        ]);

        self::assertSame(3, $instance->count());
    }

    public function testOffsetExists() : void
    {
        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
        ]);

        self::assertTrue($instance->offsetExists(0));
        self::assertTrue(isset($instance[0]));
        self::assertTrue($instance->offsetExists(1));
        self::assertTrue(isset($instance[1]));
        self::assertTrue($instance->offsetExists(2));
        self::assertTrue(isset($instance[2]));
        self::assertFalse($instance->offsetExists(3));
        self::assertFalse(isset($instance[3]));
    }

    public function testOffsetGet() : void
    {
        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
        ]);

        self::assertInstanceOf(EmptyClass::class, $instance[0]);
        self::assertInstanceOf(EmptyClass::class, $instance[1]);
        self::assertInstanceOf(EmptyClass::class, $instance[2]);
    }

    public function testInvalidOffsetGet() : void
    {
        $this->expectException(\Infinityloop\Utils\Exception\InvalidItem::class);
        $this->expectExceptionMessage(\Infinityloop\Utils\Exception\InvalidItem::MESSAGE);

        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
        ]);
        $instance->offsetGet(3);
    }

    public function testOffsetSet() : void
    {
        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([]);
        $instance[] = new \Infinityloop\Tests\Utils\EmptyClass();
        $instance[] = new \Infinityloop\Tests\Utils\EmptyClass();
        $instance[10] = new \Infinityloop\Tests\Utils\EmptyClass();

        self::assertArrayHasKey(0, $instance);
        self::assertArrayHasKey(1, $instance);
        self::assertArrayHasKey(10, $instance);
    }

    public function testInvalidOffsetSet() : void
    {
        $this->expectException(\Infinityloop\Utils\Exception\InvalidObjectOffset::class);
        $this->expectExceptionMessage(\Infinityloop\Utils\Exception\InvalidObjectOffset::MESSAGE);

        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([]);
        $instance['abc'] = new \Infinityloop\Tests\Utils\EmptyClass();
    }

    public function testOffsetUnset() : void
    {
        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
        ]);

        self::assertCount(3, $instance);
        self::assertArrayHasKey(0, $instance);
        self::assertArrayHasKey(1, $instance);
        self::assertArrayHasKey(2, $instance);

        $instance->offsetUnset(1);

        self::assertCount(2, $instance);
        self::assertArrayNotHasKey(1, $instance);

        $instance->offsetUnset(2);

        self::assertCount(1, $instance);
        self::assertArrayNotHasKey(2, $instance);

        $instance->offsetUnset(0);

        self::assertCount(0, $instance);
        self::assertArrayNotHasKey(0, $instance);
    }

    public function testInvalidOffsetUnset() : void
    {
        $this->expectException(\Infinityloop\Utils\Exception\ItemDoesntExist::class);
        $this->expectExceptionMessage(\Infinityloop\Utils\Exception\ItemDoesntExist::MESSAGE);

        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([]);
        $instance->offsetUnset(0);
    }

    public function testMerge() : void
    {
        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
        ]);

        $secondInstance = new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
        ]);

        $instance->merge($secondInstance);

        self::assertCount(6, $instance);
        self::assertCount(3, $secondInstance);
    }

    public function testMergeReplace() : void
    {
        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
        ]);

        $secondInstance = new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass(),
        ]);

        $instance->merge($secondInstance, true);

        self::assertCount(3, $instance);
        self::assertCount(3, $secondInstance);
    }

    public function testMergeInvalid() : void
    {
        $this->expectException(\Infinityloop\Utils\Exception\InvalidSetTypeToMerge::class);
        $this->expectExceptionMessage(\Infinityloop\Utils\Exception\InvalidSetTypeToMerge::MESSAGE);

        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([]);
        $secondInstance = new \Infinityloop\Tests\Utils\NamedClassSet([]);

        $instance->merge($secondInstance);
    }

    public function testInvalidInput() : void
    {
        $this->expectException(\Infinityloop\Utils\Exception\InvalidInput::class);
        $this->expectExceptionMessage(\Infinityloop\Utils\Exception\InvalidInput::MESSAGE);

        new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\NamedClass('a'),
        ]);
    }

    public function testInvalidInputScalar() : void
    {
        $this->expectException(\Infinityloop\Utils\Exception\InvalidInput::class);
        $this->expectExceptionMessage(\Infinityloop\Utils\Exception\InvalidInput::MESSAGE);

        new \Infinityloop\Tests\Utils\EmptyClassSet([
            'bla',
        ]);
    }
}
