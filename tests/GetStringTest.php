<?php

namespace OneToMany\Getters\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

use function OneToMany\Getters\get_string;

#[Group('UnitTests')]
final class GetStringTest extends TestCase
{
    public function testGettingStringWithCallableDefault(): void
    {
    }
}
