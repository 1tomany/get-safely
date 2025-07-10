<?php

namespace OneToMany\Getters\Tests;

use OneToMany\Getters\Exception\RuntimeException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

use function bin2hex;
use function OneToMany\Getters\get_string;
use function random_bytes;
use function random_int;

use const PHP_INT_MAX;

#[Group('UnitTests')]
final class GetStringTest extends TestCase
{
    #[DataProvider('providerValueAndResult')]
    public function testGettingString(mixed $value, string $result): void
    {
        $this->assertSame($result, get_string($value));
    }

    public function testGettingStringWithStringableValue(): void
    {
        $value = bin2hex(random_bytes(6));

        $stringable = new readonly class($value) implements \Stringable {
            public function __construct(
                public string $value,
            ) {
            }

            public function __toString(): string
            {
                return $this->value;
            }
        };

        $this->assertSame($value, get_string($stringable));
    }

    public function testGettingStringWithStringDefault(): void
    {
        $default = bin2hex(random_bytes(6));

        $this->assertSame($default, get_string(null, $default));
    }

    public function testGettingStringWithCallableDefault(): void
    {
        $default = bin2hex(random_bytes(6));

        $this->assertSame($default, get_string(null, fn ($v) => $default));
    }

    public function testGettingStringWithCallableDefaultOnlyExecutesCallableWhenNecessary(): void
    {
        $called = 0;

        get_string('Vic', function (mixed $value) use (&$called): string {
            return (string) (++$called);
        });

        $this->assertSame(0, $called);
    }

    public function testGettingStringWithCallableRequiresCallableToReturnString(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The callable must return a string, returned "int" instead.');

        // @phpstan-ignore-next-line
        get_string(null, function (mixed $value): int {
            return random_int(1, PHP_INT_MAX);
        });
    }

    /**
     * @return list<list<bool|int|float|string|list<int|string>|\stdClass|null>>
     */
    public static function providerValueAndResult(): array
    {
        $provider = [
            [null, ''],
            [true, ''],
            [false, ''],
            [0, ''],
            [1, ''],
            [1_024, ''],
            [1.1, ''],
            [3.149, ''],
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
