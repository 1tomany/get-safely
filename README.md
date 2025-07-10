# get-safely for PHP
This simple library exposes several PHP functions that assist with static analysis by ensuring values of unknown or mixed types are a scalar type.

## Installation
```
composer require 1tomany/get-safely
```

## Functions
- `get_string(mixed $value, string|callable $default = ''): string`
- `get_string_loose(mixed $value, string|callable $default = ''): string`

## Examples
```php
<?php

use function OneToMany\Getters\get_string;
use function OneToMany\Getters\get_string_loose;

// get_string(mixed $value, string|callable $default = ''): string
get_string(null); // string(0) ""
get_string('Vic'); // string(3) "Vic"
get_string(null, 'nope'); // string(4) "nope"
get_string(null, fn ($v) => 'callable'); // string(8) "callable"

$stringable = new class('Vic') implements \Stringable {
    function __construct(
        private string $name,
    ) {
    }

    public function __toString(): string
    {
        return $this->name;
    }
}

get_string($stringable, 'Neil'); // string(3) "Vic"

// get_string_loose() Examples
get_string_loose(null); // string(0) ""
get_string_loose(true); // string(1) "1"
get_string_loose(false); // string(0) ""
get_string_loose(10); // string(2) "10"
get_string_loose(3.14); // string(4) "3.14"
get_string_loose([], 'Vic'); // string(3) "Vic"
```

## Credits
- [Vic Cherubini](https://github.com/viccherubini), [1:N Labs, LLC](https://1tomany.com)

## License
The MIT License
