<?php

require_once __DIR__ . '/../vendor/autoload.php';

use function OneToMany\Getters\get_string;
use function OneToMany\Getters\get_string_loose;

//
// get_string() Examples
//

// string(0) ""
assert('' === get_string(null));

// string(3) "Vic"
assert('Vic' === get_string('Vic'));

// string(4) "nope"
assert('nope' === get_string(null, 'nope'));

// string(8) "callable"
assert('callable' === get_string(null, fn ($v) => 'callable'));

// string(3) "Vic"
$stringable = new class('Vic') implements \Stringable {
    function __construct(public readonly string $name)
    {
    }

    public function __toString(): string
    {
        return $this->name;
    }
};

assert($stringable->name === get_string($stringable, 'Neil'));

//
// get_string_loose() Examples
//

// string(0) ""
assert('' === get_string_loose(null));

// string(1) "1"
assert('1' === get_string_loose(true));

// string(0) ""
assert('' === get_string_loose(false));

// string(2) "10"
assert('10' === get_string_loose(10));

// string(4) "3.14"
assert('3.14' === get_string_loose(3.14));

// string(3) "Vic"
assert('Vic' === get_string_loose([], 'Vic'));
