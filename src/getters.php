<?php

namespace OneToMany\Getters;

use OneToMany\Getters\Exception\RuntimeException;

/**
 * @param string|callable(mixed): string $default
 */
function get_string(mixed $value, string|callable $default = ''): string
{
    if (\is_string($value)) {
        return $value;
    }

    if (\is_callable($default)) {
        $default = $default($value);

        if (!\is_string($default)) {
            throw new RuntimeException('The result of the callable must be a string.');
        }
    }

    return $default;
}
