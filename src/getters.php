<?php

namespace OneToMany\Getters;

use OneToMany\Getters\Exception\RuntimeException;

use function get_debug_type;
use function is_callable;
use function is_string;
use function sprintf;

/**
 * @param string|callable(mixed): string $default
 */
function get_string(mixed $value, string|callable $default = ''): string
{
    if ($value instanceof \Stringable) {
        $value = (string) $value;
    }

    if (is_string($value)) {
        return $value;
    }

    if (is_callable($default)) {
        $default = $default($value);

        if (!is_string($default)) {
            throw new RuntimeException(sprintf('The callable must return a string, returned "%s" instead.', get_debug_type($default)));
        }
    }

    return $default;
}

/**
 * @param string|callable(mixed): string $default
 */
function get_string_loose(mixed $value, string|callable $default = ''): string
{
    if (is_scalar($value)) {
        $value = (string) $value;
    }

    return get_string($value, $default);
}
