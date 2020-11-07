<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

final class ObjectMapTest extends \PHPUnit\Framework\TestCase
{
    public function testMerge() : void
    {
        $instance = new \Infinityloop\Tests\Utils\NamedClassSet([
            'a' => new \Infinityloop\Tests\Utils\NamedClass('a'),
            'b' => new \Infinityloop\Tests\Utils\NamedClass('b'),
            'c' => new \Infinityloop\Tests\Utils\NamedClass('c'),
        ]);

        $secondInstance = new \Infinityloop\Tests\Utils\NamedClassSet([
            'x' => new \Infinityloop\Tests\Utils\NamedClass('x'),
            'y' => new \Infinityloop\Tests\Utils\NamedClass('y'),
            'z' => new \Infinityloop\Tests\Utils\NamedClass('z'),
        ]);

        $instance->merge($secondInstance);

        self::assertCount(6, $instance);
        self::assertCount(3, $secondInstance);
    }

    public function testMergeReplace() : void
    {
        $instance = new \Infinityloop\Tests\Utils\NamedClassSet([
            'a' => new \Infinityloop\Tests\Utils\NamedClass('a'),
            'b' => new \Infinityloop\Tests\Utils\NamedClass('b'),
            'c' => new \Infinityloop\Tests\Utils\NamedClass('c'),
        ]);

        $secondInstance = new \Infinityloop\Tests\Utils\NamedClassSet([
            'x' => new \Infinityloop\Tests\Utils\NamedClass('x'),
            'y' => new \Infinityloop\Tests\Utils\NamedClass('y'),
            'a' => new \Infinityloop\Tests\Utils\NamedClass('z'),
        ]);

        $instance->merge($secondInstance, true);

        self::assertCount(5, $instance);
        self::assertCount(3, $secondInstance);
    }

    public function testMergeNoReplace() : void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Item already exists, use $allowReplace if you wish to replace');

        $instance = new \Infinityloop\Tests\Utils\NamedClassSet([
            'a' => new \Infinityloop\Tests\Utils\NamedClass('a'),
            'b' => new \Infinityloop\Tests\Utils\NamedClass('b'),
            'c' => new \Infinityloop\Tests\Utils\NamedClass('c'),
        ]);

        $secondInstance = new \Infinityloop\Tests\Utils\NamedClassSet([
            'x' => new \Infinityloop\Tests\Utils\NamedClass('x'),
            'y' => new \Infinityloop\Tests\Utils\NamedClass('y'),
            'a' => new \Infinityloop\Tests\Utils\NamedClass('z'),
        ]);

        $instance->merge($secondInstance);
    }

    public function testInvalidOffsetSet() : void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid offset for given object');

        $instance = new \Infinityloop\Tests\Utils\NamedClassSet();
        $instance[1] = new NamedClass('a');
    }
}
