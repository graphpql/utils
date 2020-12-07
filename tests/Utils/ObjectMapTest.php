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
        $this->expectException(\Infinityloop\Utils\Exception\ItemAlreadyExists::class);
        $this->expectExceptionMessage(\Infinityloop\Utils\Exception\ItemAlreadyExists::MESSAGE);

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
        $this->expectException(\Infinityloop\Utils\Exception\InvalidObjectOffset::class);
        $this->expectExceptionMessage(\Infinityloop\Utils\Exception\InvalidObjectOffset::MESSAGE);

        $instance = new \Infinityloop\Tests\Utils\NamedClassSet();
        $instance[1] = new \Infinityloop\Tests\Utils\NamedClass('a');
    }
}
