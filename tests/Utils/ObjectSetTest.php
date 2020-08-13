<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

final class ObjectSetTest extends \PHPUnit\Framework\TestCase
{
    public function testInvalidArgument() : void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Invalid input.');

        $data = ['bla', new \Infinityloop\Tests\Utils\EmptyClass(), new \Infinityloop\Tests\Utils\EmptyClass()];
        new \Infinityloop\Tests\Utils\EmptyClassSet($data);
    }

    public function testDuplicatedItem() : void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Duplicated item. Set using explicit key if you wish to replace.');

        new \Infinityloop\Tests\Utils\NamedClassSet([
            new \Infinityloop\Tests\Utils\NamedClass('duplicatedKey'),
            new \Infinityloop\Tests\Utils\NamedClass('duplicatedKey'),
        ]);
    }

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

    public function testOffsetExistsInteger() : void
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

    public function testOffsetExistsNamed() : void
    {
        $instance = new \Infinityloop\Tests\Utils\NamedClassSet([
            new \Infinityloop\Tests\Utils\NamedClass('a'),
            new \Infinityloop\Tests\Utils\NamedClass('b'),
            new \Infinityloop\Tests\Utils\NamedClass('c'),
        ]);

        self::assertTrue($instance->offsetExists('a'));
        self::assertTrue(isset($instance['a']));
        self::assertTrue($instance->offsetExists('b'));
        self::assertTrue(isset($instance['b']));
        self::assertTrue($instance->offsetExists('c'));
        self::assertTrue(isset($instance['c']));
        self::assertFalse($instance->offsetExists('d'));
        self::assertFalse(isset($instance['d']));
    }

    public function testOffsetGetInteger() : void
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

    public function testOffsetGetNamed() : void
    {
        $instance = new \Infinityloop\Tests\Utils\NamedClassSet([
            new \Infinityloop\Tests\Utils\NamedClass('a'),
            new \Infinityloop\Tests\Utils\NamedClass('b'),
            new \Infinityloop\Tests\Utils\NamedClass('c'),
        ]);

        self::assertInstanceOf(NamedClass::class, $instance['a']);
        self::assertInstanceOf(NamedClass::class, $instance['b']);
        self::assertInstanceOf(NamedClass::class, $instance['c']);
    }

    public function testInvalidOffsetGetInteger() : void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Item doesnt exist.');

        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([
            new \Infinityloop\Tests\Utils\EmptyClass(),
            new \Infinityloop\Tests\Utils\EmptyClass()]
        );
        $instance->offsetGet(3);
    }

    public function testInvalidOffsetGetNamed() : void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Item doesnt exist.');

        $instance = new \Infinityloop\Tests\Utils\NamedClassSet([
            new \Infinityloop\Tests\Utils\NamedClass('a'),
            new \Infinityloop\Tests\Utils\NamedClass('b'),
        ]);
        $instance->offsetGet('c');
    }

    public function testInvalidClass() : void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Invalid input.');

        new \Infinityloop\Tests\Utils\EmptyClassSet([
            new NamedClass('a'),
        ]);
    }

    public function testOffsetSetInteger() : void
    {
        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([]);
        $instance[] = new EmptyClass();
        $instance[] = new EmptyClass();
        $instance[10] = new EmptyClass();

        self::assertArrayHasKey(0, $instance);
        self::assertArrayHasKey(1, $instance);
        self::assertArrayHasKey(10, $instance);
    }

    public function testInvalidOffsetSetInteger() : void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Invalid offset for given object.');

        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([]);
        $instance['abc'] = new EmptyClass();
    }

    public function testOffsetSetNamed() : void
    {
        $instance = new \Infinityloop\Tests\Utils\NamedClassSet([]);
        $instance[] = new NamedClass('a');
        $instance['b'] = new NamedClass('b');
        $instance[] = new NamedClass('c');

        self::assertArrayHasKey('a', $instance);
        self::assertArrayHasKey('b', $instance);
        self::assertArrayHasKey('c', $instance);
    }

    public function testInvalidOffsetSetNamedTypeMismatch() : void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Invalid offset for given object.');

        $instance = new \Infinityloop\Tests\Utils\NamedClassSet([]);
        $instance[123] = new NamedClass('123');
    }

    public function testInvalidOffsetSetNamedNameMismatch() : void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Invalid offset for given object.');

        $instance = new \Infinityloop\Tests\Utils\NamedClassSet([]);
        $instance['a'] = new NamedClass('b');
    }

    public function testOffsetSetNamedExplicitReplace() : void
    {
        $instance = new \Infinityloop\Tests\Utils\NamedClassSet([]);
        $instance[] = new NamedClass('b');
        $instance['b'] = new NamedClass('b');

        self::assertCount(1, $instance);
        self::assertArrayHasKey('b', $instance);
    }

    public function testInvalidOffsetSetNamedExplicitReplace() : void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Duplicated item. Set using explicit key if you wish to replace.');

        $instance = new \Infinityloop\Tests\Utils\NamedClassSet([]);
        $instance[] = new NamedClass('b');
        $instance[] = new NamedClass('b');
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
        $this->expectException('Exception');
        $this->expectExceptionMessage('Item already doesnt exist.');

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
        $this->expectException('Exception');
        $this->expectExceptionMessage('I can only merge ObjectSets of same type');

        $instance = new \Infinityloop\Tests\Utils\EmptyClassSet([]);
        $secondInstance = new \Infinityloop\Tests\Utils\NamedClassSet([]);

        $instance->merge($secondInstance);
    }
}
