<?php

declare(strict_types = 1);

namespace Inifnityloop\Utils\Tests;

final class CaseConverterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider toSnakeCaseDataProvider
     */
    public function testToSnakeCase(string $expected, string $test) : void
    {
        self::assertSame($expected, \Infinityloop\Utils\CaseConverter::toSnakeCase($test));
    }

    public function toSnakeCaseDataProvider() : array
    {
        return [
            ['abc', 'Abc'],
            ['abc_abc', 'AbcAbc'],
            ['abc_123_abc', 'Abc123Abc'],
        ];
    }

    /**
     * @dataProvider toCamelCaseDataProvider
     */
    public function testToCamelCase(string $expected, string $test) : void
    {
        self::assertSame($expected, \Infinityloop\Utils\CaseConverter::toCamelCase($test));
    }

    public function toCamelCaseDataProvider() : array
    {
        return [
            ['abc', 'Abc'],
            ['abcAbc', 'AbcAbc'],
            ['abc123Abc', 'Abc123Abc'],
        ];
    }

    /**
     * @dataProvider toPascalCaseDataProvider
     */
    public function testToPascalCase(string $expected, string $test) : void
    {
        self::assertSame($expected, \Infinityloop\Utils\CaseConverter::toPascalCase($test));
    }

    public function toPascalCaseDataProvider() : array
    {
        return [
            ['Abc', 'Abc'],
            ['AbcAbc', 'AbcAbc'],
            ['Abc123Abc', 'Abc123Abc'],
        ];
    }

    /**
     * @dataProvider toKebabCaseDataProvider
     */
    public function testToKebabCase(string $expected, string $test) : void
    {
        self::assertSame($expected, \Infinityloop\Utils\CaseConverter::toKebabCase($test));
    }

    public function toKebabCaseDataProvider() : array
    {
        return [
            ['abc', 'Abc'],
            ['abc-abc', 'AbcAbc'],
            ['abc-123-abc', 'Abc123Abc'],
        ];
    }

    /**
     * @dataProvider splitWordsDataProvider
     */
    public function testSplitWords(string $test, array $expected) : void
    {
        self::assertSame($expected, \array_values(\Infinityloop\Utils\CaseConverter::splitWords($test)));
    }

    /**
     * @dataProvider splitWordsDataProvider
     */
    public function testInverse(string $test, array $expected) : void
    {
        $snake = \App\Helper\CaseConverter::toSnakeCase($test);
        self::assertSame($snake, \Infinityloop\Utils\CaseConverter::toSnakeCase(\Infinityloop\UtilsCaseConverter::toPascalCase($snake)));
        self::assertSame($snake, \Infinityloop\Utils\CaseConverter::toSnakeCase(\Infinityloop\Utils\CaseConverter::toCamelCase($snake)));
        self::assertSame($snake, \Infinityloop\Utils\CaseConverter::toSnakeCase(\Infinityloop\Utils\CaseConverter::toKebabCase($snake)));

        $pascal = \App\Helper\CaseConverter::toPascalCase($test);
        self::assertSame($pascal, \Infinityloop\Utils\CaseConverter::toPascalCase(\Infinityloop\Utils\CaseConverter::toSnakeCase($pascal)));
        self::assertSame($pascal, \Infinityloop\Utils\CaseConverter::toPascalCase(\Infinityloop\Utils\CaseConverter::toCamelCase($pascal)));
        self::assertSame($pascal, \Infinityloop\Utils\CaseConverter::toPascalCase(\Infinityloop\Utils\CaseConverter::toKebabCase($pascal)));

        $camel = \App\Helper\CaseConverter::toCamelCase($test);
        self::assertSame($camel, \Infinityloop\Utils\CaseConverter::toCamelCase(\Infinityloop\Utils\CaseConverter::toPascalCase($camel)));
        self::assertSame($camel, \Infinityloop\Utils\CaseConverter::toCamelCase(\Infinityloop\Utils\CaseConverter::toSnakeCase($camel)));
        self::assertSame($camel, \Infinityloop\Utils\CaseConverter::toCamelCase(\Infinityloop\Utils\CaseConverter::toKebabCase($camel)));

        $kebab = \App\Helper\CaseConverter::toKebabCase($test);
        self::assertSame($kebab, \Infinityloop\Utils\CaseConverter::toKebabCase(\Infinityloop\Utils\CaseConverter::toPascalCase($kebab)));
        self::assertSame($kebab, \Infinityloop\UtilsCaseConverter::toKebabCase(\Infinityloop\Utils\CaseConverter::toCamelCase($kebab)));
        self::assertSame($kebab, \Infinityloop\Utils\CaseConverter::toKebabCase(\Infinityloop\Utils\CaseConverter::toSnakeCase($kebab)));
    }

    public function splitWordsDataProvider() : array
    {
        return [
            ['abc', ['abc']],
            ['_abc', ['abc']],
            ['__abc', ['abc']],
            ['abc_', ['abc']],
            ['abc__', ['abc']],
            ['-abc', ['abc']],
            ['--abc', ['abc']],
            ['abc-', ['abc']],
            ['abc--', ['abc']],
            ['abc_def', ['abc', 'def']],
            ['abc__def', ['abc', 'def']],
            ['abc-def', ['abc', 'def']],
            ['abc--def', ['abc', 'def']],
            ['abc_def_ghi', ['abc', 'def', 'ghi']],
            ['abc-def-ghi', ['abc', 'def', 'ghi']],
            ['abc123_ghi', ['abc', '123', 'ghi']],
            ['abc123-ghi', ['abc', '123', 'ghi']],
            ['abc_123ghi', ['abc', '123', 'ghi']],
            ['abc-123ghi', ['abc', '123', 'ghi']],
            ['abc_123_ghi', ['abc', '123', 'ghi']],
            ['abc-123-ghi', ['abc', '123', 'ghi']],
            ['Abc', ['abc']],
            ['AbcDef', ['abc', 'def']],
            ['AbcDefGhi', ['abc', 'def', 'ghi']],
            ['Abc123Ghi', ['abc', '123', 'ghi']],
            ['Abc123ghi', ['abc', '123', 'ghi']],
            ['AbcD123Ghi', ['abc', 'd', '123', 'ghi']],
            ['-AbcD123Ghi_abc_def_ghi-abc-def123-ghi__',
                ['abc', 'd', '123', 'ghi', 'abc', 'def', 'ghi', 'abc', 'def', '123', 'ghi'],
            ],
        ];
    }
}
