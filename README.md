# Utils [![PHP](https://github.com/infinityloop-dev/utils/workflows/PHP/badge.svg?branch=master)](https://github.com/infinityloop-dev/utils/actions?query=workflow%3APHP)

:hammer: Common utility classes for infinityloop packages.

## Introduction

This component provides some utility classes which are used across infinityloop packages.

## Installation

Install package using composer

```
composer require infinityloop-dev/utils
```

## Dependencies

- PHP >= 7.4
- [nette/utils](https://github.com/nette/utils)

## Classes

### Json

Json wrapper which allows you to work with Json as if it was array. Decoding and encoding is fully lazy.

```
$json = Json::fromString($jsonString);      // (no decoding is done at this step)

$json['foo'] = 'bar';                       // adding/updating values (decoding is done on this step)
unset($json['foo2']);                       // removing value
$json->foo3= 'bar3;                         // magic interface is also available

$jsonString = $json->toString();            // (encoding of updated array into string again)
$jsonString = $json->toString();            // (no encoding is done, because previously encoded string is up to date)
```

### CaseConverter

Simple class which transforms case of strings.

```
$string = 'foo-bar_bazFoo123baz';

CaseConverter::toCamelCase($string);        // fooBarBazFoo123Baz
CaseConverter::toPascalCase($string);       // FooBarBazFoo123Baz
CaseConverter::toSnakeCase($string);        // foo_bar_baz_foo_123_baz
CaseConverter::toKebabCase($string);        // foo-bar-baz-foo-123-baz
CaseConverter::splitWords($string);         // [ foo, bar, baz, foo, 123, baz ]
```

### ClassSet

Typesafe array of objects of a same type.

```
class Foo { public string $name; public function __construct(string $name) { $this->name = $name; } }
class FooSet extends ObjectSet { protected const INNER_CLASS = Foo::class; }

$set = new FooSet([new Foo(), new Bar(), new Baz()]); // error

// automaticaly generated index keys
$set = new FooSet([new Foo('foo1'), new Foo('foo2'), new Foo('foo3')]);
echo $set[0]->name; // foo1
echo $set[1]->name; // foo2
echo $set[2]->name; // foo3

class NamedFooSet extends ObjectSet 
{ 
    protected const INNER_CLASS = Foo::class; 

    protected function getKey($fooObject)
    {
        return $fooObject->name;
    }
}

// named keys
$set = new NamedFooSet([new Foo('foo1'), new Foo('foo2'), new Foo('foo3')]);
echo $set['foo1']->name; // foo1
echo $set['foo2']->name; // foo2
echo $set['foo3']->name; // foo3
```
