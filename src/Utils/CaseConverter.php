<?php

declare(strict_types = 1);

namespace App\Helper;

final class CaseConverter
{
    use \Nette\StaticClass;

    public static function toPascalCase(string $string) : string
    {
        return \implode('', self::splitWords($string, true));
    }

    public static function toCamelCase(string $string) : string
    {
        return \lcfirst(self::toPascalCase($string));
    }

    public static function toSnakeCase(string $string) : string
    {
        return \implode('_', self::splitWords($string));
    }

    public static function toKebabCase(string $string) : string
    {
        return \implode('-', self::splitWords($string));
    }

    public static function splitWords(string $full, bool $ucFirst = false) : array
    {
        return \array_map(static function(string $word) use ($ucFirst) : string {
            return $ucFirst
                ? \ucfirst(\strtolower($word))
                : \strtolower($word);
        }, \array_filter(\preg_split('/(?=[A-Z])|[_\-]|(?=[\d])(?<![\d])|(?=[a-zA-Z])(?<=[\d])/', $full)));
    }
}
