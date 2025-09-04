<?php
declare(strict_types=1);

namespace Blibio\Combinatorics\Test\Combination;

use Blibio\Combinatorics\Combinatorics;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class WithoutRepetitionTest extends TestCase
{
    public function testThrowsOnNumGreaterThanElements(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$k (2) must not be greater than number of elements (1)');

        Combinatorics::combinationsWithoutRepetition(['A'], 2);
    }

    /**
     * @param list<mixed> $elements
     * @param array<array-key, mixed> $expected
     */
    #[DataProvider('results')]
    public function testResults(array $elements, int $k, array $expected): void
    {
        /** @phpstan-ignore argument.type */
        $uut = Combinatorics::combinationsWithoutRepetition($elements, $k);

        $i = 0;
        foreach ($uut as $set) {
            self::assertEquals($set, $expected[$i++]);
        }
    }

    /**
     * @param list<mixed> $elements
     * @param array<array-key, mixed> $expected
     */
    #[DataProvider('results')]
    public function testCounts(array $elements, int $k, array $expected): void
    {
        /** @phpstan-ignore argument.type */
        $uut = Combinatorics::combinationsWithoutRepetition($elements, $k);

        self::assertCount(count($expected), $uut);
    }

    /** @return array<array-key, mixed> */
    public static function results(): array
    {
        return [
            [
                ['A'], 1,
                [
                    ['A'],
                ],
            ], [
                ['A', 'B', 'C'], 1,
                [
                    ['A'],
                    ['B'],
                    ['C'],
                ],
            ], [
                ['A', 'B', 'C'], 2,
                [
                    ['A', 'B'],
                    ['A', 'C'],
                    ['B', 'C'],
                ],
            ], [
                ['A', 'B', 'C'], 3,
                [
                    ['A', 'B', 'C'],
                ],
            ], [
                ['A', 'B'], 2,
                [
                    ['A', 'B'],
                ],
            ], [
                ['A', 'B', 'C', 'D', 'E'], 3,
                [
                    ['A', 'B', 'C'],
                    ['A', 'B', 'D'],
                    ['A', 'B', 'E'],
                    ['A', 'C', 'D'],
                    ['A', 'C', 'E'],
                    ['A', 'D', 'E'],
                    ['B', 'C', 'D'],
                    ['B', 'C', 'E'],
                    ['B', 'D', 'E'],
                    ['C', 'D', 'E']
                ],
            ],
        ];
    }
}
