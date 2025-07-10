<?php

namespace OneToMany\Getters\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

use function OneToMany\Getters\get_string;

#[Group('UnitTests')]
final class GetStringTest extends TestCase
{
    #[DataProvider('providerValueAndResult')]
    public function testGettingString(mixed $value, string $result): void
    {
        $this->assertSame($result, get_string($value));
    }

    /**
     * @return list<list<null|bool|int|float|string|list<int|string>|\stdClass>>
     */
    public static function providerValueAndResult(): array
    {
        $provider = [
            [null, ''],
            [true, '1'],
            [false, ''],
            [0, '0'],
            [1, '1'],
            [1_024, '1024'],
            [1.1, '1.1'],
            [3.149, '3.149'],
            ['', ''],
            [' ', ' '],
            ['A', 'A'],
            [[], ''],
            [[1], ''],
            [['a'], ''],
            [new \stdClass(), ''],
        ];

        return $provider;
    }
}
