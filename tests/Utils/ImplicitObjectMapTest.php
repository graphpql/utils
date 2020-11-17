<?php

declare(strict_types = 1);

namespace Infinityloop\Tests\Utils;

final class ImplicitObjectMapTest extends \PHPUnit\Framework\TestCase
{
    public function testInitialization() : void
    {
        $instance = new \Infinityloop\Tests\Utils\ImplicitNamedClassSet([
            'a' => new \Infinityloop\Tests\Utils\NamedClass('a'),
            'b' => new \Infinityloop\Tests\Utils\NamedClass('b'),
            'c' => new \Infinityloop\Tests\Utils\NamedClass('c'),
        ]);

        self::assertCount(3, $instance);
        self::assertArrayHasKey('a', $instance);
        self::assertArrayHasKey('b', $instance);
        self::assertArrayHasKey('c', $instance);
    }

    public function testInitializationWithoutKeys() : void
    {
        $instance = new \Infinityloop\Tests\Utils\ImplicitNamedClassSet([
            new \Infinityloop\Tests\Utils\NamedClass('a'),
            new \Infinityloop\Tests\Utils\NamedClass('b'),
            new \Infinityloop\Tests\Utils\NamedClass('c'),
        ]);

        self::assertCount(3, $instance);
        self::assertArrayHasKey('a', $instance);
        self::assertArrayHasKey('b', $instance);
        self::assertArrayHasKey('c', $instance);
    }

    public function testInitializationWithoutKeysDuplicated() : void
    {
        $this->expectException(\Infinityloop\Utils\Exception\DuplicateItemError::class);
        $this->expectExceptionMessage(\Infinityloop\Utils\Exception\DuplicateItemError::MESSAGE);

        new \Infinityloop\Tests\Utils\ImplicitNamedClassSet([
            new \Infinityloop\Tests\Utils\NamedClass('a'),
            new \Infinityloop\Tests\Utils\NamedClass('a'),
        ]);
    }

    public function testInvalidOffsetSet() : void
    {
        $this->expectException(\Infinityloop\Utils\Exception\InvalidImplicitObjectOffsetSetImpl::class);
        $this->expectExceptionMessage(\Infinityloop\Utils\Exception\InvalidImplicitObjectOffsetSetImpl::MESSAGE);

        $instance = new \Infinityloop\Tests\Utils\ImplicitNamedClassSet();
        $instance[1] = new \Infinityloop\Tests\Utils\NamedClass('a');
    }
}
