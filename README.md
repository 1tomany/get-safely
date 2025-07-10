# get-safely for PHP
This simple library exposes several PHP functions that assist with static analysis by ensuring values of unknown or mixed types are a scalar type.

## Installation
```
composer require 1tomany/get-safely
```

## Functions
### `get_string(): string`
This function returns the `$value` argument if it is a string or implements the `\Stringable` interface, otherwise it returns the value of the `$default` argument. If the `$default` argument is of type `callable`, the `$value` is passed to it and the result of the callable is returned. An exception is thrown if the callable does not return a string.

#### Arguments
- `mixed $value`
- `string|callable $default = ''`

### `get_string_loose(): string`
This function is identical to `get_string()` _except_ the `$value` argument is first cast to a string if it is a scalar value (`boolean`, `int`, `float`, or `string` in PHP).

#### Arguments
- `mixed $value`
- `string|callable $default = ''`

## Examples
```php
<?php

use function OneToMany\Getters\get_string;
use function OneToMany\Getters\get_string_loose;

//
// get_string() Examples
//

// string(0) ""
get_string(null);

// string(3) "Vic"
get_string('Vic');

// string(4) "nope"
get_string(null, 'nope');

// string(8) "callable"
get_string(null, fn ($v) => 'callable');

// string(3) "Vic"
get_string(new class('Vic') implements \Stringable {
    function __construct(
        private string $name,
    ) {
    }

    public function __toString(): string
    {
        return $this->name;
    }
}, 'Neil');

//
// get_string_loose() Examples
//

// string(0) ""
get_string_loose(null);

// string(1) "1"
get_string_loose(true);

// string(0) ""
get_string_loose(false);

// string(2) "10"
get_string_loose(10);

// string(4) "3.14"
get_string_loose(3.14);

// string(3) "Vic"
get_string_loose([], 'Vic');
```

## Credits
- [Vic Cherubini](https://github.com/viccherubini), [1:N Labs, LLC](https://1tomany.com)

## License
The MIT License
