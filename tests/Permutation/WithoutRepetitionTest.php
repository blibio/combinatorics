<?php
declare(strict_types=1);

namespace Blibio\Combinatorics\Test\Permutation;

use Blibio\Combinatorics\Combinatorics;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class WithoutRepetitionTest extends TestCase
{
    public function testThrowsOnEmptyArray(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot generate combinations/permutations from empty array.');

        Combinatorics::permutationsWithoutRepetition([], 1);
    }

    public function testThrowsOnNumLessThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$k must be greater than zero, got: -1');

        /** @phpstan-ignore argument.type */
        Combinatorics::permutationsWithoutRepetition(['A'], -1);
    }

    public function testThrowsOnNumGreaterThanElements(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$k (2) must not be greater than number of elements (1)');

        Combinatorics::permutationsWithoutRepetition(['A'], 2);
    }

    /**
     * @param list<mixed> $elements
     * @param array<array-key, mixed> $expected
     */
    #[DataProvider('results')]
    public function testResults(array $elements, int $k, array $expected): void
    {
        /** @phpstan-ignore argument.type */
        $uut = Combinatorics::permutationsWithoutRepetition($elements, $k);

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
        $uut = Combinatorics::permutationsWithoutRepetition($elements, $k);

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
            ],
            [
                ['A', 'B', 'C'], 2,
                [
                    ['A', 'B'],
                    ['A', 'C'],
                    ['B', 'A'],
                    ['B', 'C'],
                    ['C', 'A'],
                    ['C', 'B'],
                ],
            ], [
                ['A', 'B'], 2,
                [
                    ['A', 'B'],
                    ['B', 'A'],
                ],
            ], [
                ['A', 'B', 'C'], 3,
                [
                    ['A', 'B', 'C'],
                    ['A', 'C', 'B'],
                    ['B', 'A', 'C'],
                    ['B', 'C', 'A'],
                    ['C', 'A', 'B'],
                    ['C', 'B', 'A'],
                ],
            ],
        ];
    }
}
