<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

use Nette\Utils\Reflection;

final class ObjectSetTest extends \PHPUnit\Framework\TestCase
{
    public function testInvalidArgument() : void
    {
        self::expectException('Exception');
        self::expectExceptionMessage('Invalid input.');

        $data = ["bla" ,new Bla(), new Bla()];
        $instance = new BlaSet($data);
    }

    public function testDuplicatedItem() : void
    {
        self::expectException('Exception');
        self::expectExceptionMessage('Duplicated item.');

        $data = [new Boo(),'test' => new Boo(), new Boo()];
        $instance = new BooSet($data);
    }

    public function testToArray() : void
    {
        $data = [new Bla(), new Bla()];
        $instance = new BlaSet($data);

        self::assertEquals([0 => new Bla(), 1 => new Bla()], $instance->toArray());
    }

    public function testCurrent() : void
    {
        $data = [new Bla(), new Bla()];
        $instance = new BlaSet($data);

        self::assertEquals(new Bla(), $instance->current());
    }

    public function testNext() : void
    {
        $data = [new Bla()];
        $instance = new BlaSet($data);
        $instance->next();

        self::assertSame(false , $instance->valid());
    }

    public function testKey() : void
    {
        $data = [new Bla(), new Bla()];
        $instance = new BlaSet($data);

        self::assertArrayHasKey(0, $instance->toArray());
        self::assertSame(0 , $instance->key());
        self::assertNotNull($instance->key());
    }

    public function testValid() : void
    {
        $data = [new Bla(), new Bla()];
        $instance = new BlaSet($data);

        self::assertSame(true , $instance->valid());
    }

    public function testRewind() : void
    {
        $data = [new Bla(), new Bla()];
        $instance = new BlaSet($data);
        $instance->next();
        $instance->rewind();

        self::assertSame(0 , $instance->key());
    }

    public function testCount() : void
    {
        $data = [new Bla(), new Bla(), new Bla()];
        $instance = new BlaSet($data);

        self::assertSame(3 , $instance->count());
    }

    public function testOffsetExists() : void
    {
        $data = [new Bla(), new Bla(), new Bla()];
        $instance = new BlaSet($data);

        self::assertSame(true, $instance->offsetExists(1));
    }

    public function testOffsetGet() : void
    {
        $data = [new Bla(), new Bla(), new Bla()];
        $instance = new BlaSet($data);

        self::assertEquals(new Bla(), $instance->offsetGet(1));
    }

    public function testInvalidOffsetGet() : void
    {
        self::expectException('Exception');
        self::expectExceptionMessage('Item doesnt exist.');

        $data = [new Bla(), new Bla()];
        $instance = new BlaSet($data);
        $instance->offsetGet(3);
    }

    public function testOffsetSet() : void
    {
        $data = [new Bla(), new Bla()];
        $instance = new BlaSet($data);
        $instance->offsetSet(5, new Bla());

        self::assertTrue($instance->offsetExists(5));
        self::assertEquals(new Bla(), $instance->offsetGet(5));
    }

   public function testInvalidOffsetSet() : void
    {
        self::expectException('Exception');
        self::expectExceptionMessage('Invalid offset for given object.');

        $instance = new class([]) extends \Infinityloop\Utils\ObjectSet
        {
            protected function getKey($object)
            {
                return 'test';
            }
        };

        $instance->offsetSet('', new class(){});
    }

    public function testOffsetUnset() : void
    {
        $data = [new Bla(), new Bla(), new Bla()];
        $instance = new BlaSet($data);
        $instance->offsetUnset(1);

        self::assertSame(false, $instance->offsetExists(1));
    }

    public function testInvalidOffsetUnset() : void
    {
        self::expectException('Exception');
        self::expectExceptionMessage('Item already doesnt exist.');

        $data = [new Bla(), new Bla(), new Bla()];
        $instance = new BlaSet($data);
        $instance->offsetUnset('c');
    }

    public function testGetKey() : void
    {
        $reflection = new \ReflectionClass(\Infinityloop\Utils\ObjectSet::class);
        $method = $reflection->getMethod('getKey');
        $method->setAccessible(true);

        $data = [new Bla(), new Bla(), new Bla()];
        self::assertNull($method->invokeArgs(new BlaSet($data), [new Bla()]));
    }

    public function testGetKeyVisibility() : void
    {
        self::assertTrue((new \ReflectionClass(\Infinityloop\Utils\ObjectSet::class))->getMethod('getKey')->isProtected());
    }
}