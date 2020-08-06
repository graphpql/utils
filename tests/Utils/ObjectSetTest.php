<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

final class ObjectSetTest extends \PHPUnit\Framework\TestCase
{
    public function testInvalidArgument() : void
    {
        self::expectException('Exception');
        self::expectExceptionMessage('Invalid input.');

        $data = ['bla' ,new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        new \Infinityloop\Tests\Utils\BlaSet($data);
    }

    public function testDuplicatedItem() : void
    {
        self::expectException('Exception');
        self::expectExceptionMessage('Duplicated item.');

        $data = [new \Infinityloop\Tests\Utils\Boo(),'test' => new \Infinityloop\Tests\Utils\Boo(), new \Infinityloop\Tests\Utils\Boo()];
        new \Infinityloop\Tests\Utils\BooSet($data);
    }

    public function testToArray() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);

        self::assertEquals([0 => new \Infinityloop\Tests\Utils\Bla(), 1 => new \Infinityloop\Tests\Utils\Bla()], $instance->toArray());
    }

    public function testCurrent() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);

        self::assertEquals(new \Infinityloop\Tests\Utils\Bla(), $instance->current());
    }

    public function testNext() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);
        $instance->next();

        self::assertSame(false, $instance->valid());
    }

    public function testKey() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);

        self::assertArrayHasKey(0, $instance->toArray());
        self::assertSame(0, $instance->key());
        self::assertNotNull($instance->key());
    }

    public function testValid() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);

        self::assertSame(true, $instance->valid());
    }

    public function testRewind() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);
        $instance->next();
        $instance->rewind();

        self::assertSame(0, $instance->key());
    }

    public function testCount() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);

        self::assertSame(3, $instance->count());
    }

    public function testOffsetExists() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);

        self::assertSame(true, $instance->offsetExists(1));
    }

    public function testOffsetGet() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);

        self::assertEquals(new \Infinityloop\Tests\Utils\Bla(), $instance->offsetGet(1));
    }

    public function testInvalidOffsetGet() : void
    {
        self::expectException('Exception');
        self::expectExceptionMessage('Item doesnt exist.');

        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);
        $instance->offsetGet(3);
    }

    public function testOffsetSet() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);
        $instance->offsetSet(5, new \Infinityloop\Tests\Utils\Bla());

        self::assertTrue($instance->offsetExists(5));
        self::assertEquals(new \Infinityloop\Tests\Utils\Bla(), $instance->offsetGet(5));
    }

    public function testOffsetSetReturn() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);
        $instance->offsetSet(null, new \Infinityloop\Tests\Utils\Bla());

        self::assertFalse($instance->offsetExists(null));
    }

    public function testInvalidOffsetSet() : void
    {
        self::expectException('Exception');
        self::expectExceptionMessage('Invalid offset for given object.');

        $instance = new class ([]) extends \Infinityloop\Utils\ObjectSet
        {
            protected function getKey($object) : string
            {
                return 'test';
            }
        };
        $anonymousClass = new class ()
        {
        };
        $instance->offsetSet('', $anonymousClass);
    }

    public function testOffsetUnset() : void
    {
        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);
        $instance->offsetUnset(1);

        self::assertSame(false, $instance->offsetExists(1));
    }

    public function testInvalidOffsetUnset() : void
    {
        self::expectException('Exception');
        self::expectExceptionMessage('Item already doesnt exist.');

        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        $instance = new \Infinityloop\Tests\Utils\BlaSet($data);
        $instance->offsetUnset('c');
    }

    public function testGetKey() : void
    {
        $reflection = new \ReflectionClass(\Infinityloop\Utils\ObjectSet::class);
        $method = $reflection->getMethod('getKey');
        $method->setAccessible(true);

        $data = [new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla(), new \Infinityloop\Tests\Utils\Bla()];
        self::assertNull($method->invokeArgs(new \Infinityloop\Tests\Utils\BlaSet($data), [new \Infinityloop\Tests\Utils\Bla()]));
    }

    public function testGetKeyVisibility() : void
    {
        self::assertTrue((new \ReflectionClass(\Infinityloop\Utils\ObjectSet::class))->getMethod('getKey')->isProtected());
    }
}
