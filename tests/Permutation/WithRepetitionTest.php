<?php
declare(strict_types=1);

namespace Blibio\Combinatorics\Test\Permutation;

use Blibio\Combinatorics\Combinatorics;
use Countable;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Traversable;

final class WithRepetitionTest extends TestCase
{
    public function testThrowsOnEmptyArray(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot generate combinations/permutations from empty array.');

        Combinatorics::permutationsWithRepetition([], 1);
    }

    public function testThrowsOnNumLessThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$k must be greater than zero, got: -1');

        /** @phpstan-ignore argument.type */
        Combinatorics::permutationsWithRepetition(['A'], -1);
    }

    /**
     * @param list<mixed> $elements
     * @param array<array-key, mixed> $expected
     */
    #[DataProvider('results')]
    public function testResults(array $elements, int $k, array $expected): void
    {
        /** @phpstan-ignore argument.type */
        $uut = Combinatorics::permutationsWithRepetition($elements, $k);

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
        $uut = Combinatorics::permutationsWithRepetition($elements, $k);

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
                    ['A', 'A'],
                    ['A', 'B'],
                    ['A', 'C'],
                    ['B', 'A'],
                    ['B', 'B'],
                    ['B', 'C'],
                    ['C', 'A'],
                    ['C', 'B'],
                    ['C', 'C'],
                ],
            ], [
                ['A', 'B', 'C'], 3,
                [
                    ['A', 'A', 'A'],
                    ['A', 'A', 'B'],
                    ['A', 'A', 'C'],
                    ['A', 'B', 'A'],
                    ['A', 'B', 'B'],
                    ['A', 'B', 'C'],
                    ['A', 'C', 'A'],
                    ['A', 'C', 'B'],
                    ['A', 'C', 'C'],
                    ['B', 'A', 'A'],
                    ['B', 'A', 'B'],
                    ['B', 'A', 'C'],
                    ['B', 'B', 'A'],
                    ['B', 'B', 'B'],
                    ['B', 'B', 'C'],
                    ['B', 'C', 'A'],
                    ['B', 'C', 'B'],
                    ['B', 'C', 'C'],
                    ['C', 'A', 'A'],
                    ['C', 'A', 'B'],
                    ['C', 'A', 'C'],
                    ['C', 'B', 'A'],
                    ['C', 'B', 'B'],
                    ['C', 'B', 'C'],
                    ['C', 'C', 'A'],
                    ['C', 'C', 'B'],
                    ['C', 'C', 'C'],
                ],
            ], [
                ['A', 'B', 'C'], 4,
                [
                    ['A', 'A', 'A', 'A'],
                    ['A', 'A', 'A', 'B'],
                    ['A', 'A', 'A', 'C'],
                    ['A', 'A', 'B', 'A'],
                    ['A', 'A', 'B', 'B'],
                    ['A', 'A', 'B', 'C'],
                    ['A', 'A', 'C', 'A'],
                    ['A', 'A', 'C', 'B'],
                    ['A', 'A', 'C', 'C'],
                    ['A', 'B', 'A', 'A'],
                    ['A', 'B', 'A', 'B'],
                    ['A', 'B', 'A', 'C'],
                    ['A', 'B', 'B', 'A'],
                    ['A', 'B', 'B', 'B'],
                    ['A', 'B', 'B', 'C'],
                    ['A', 'B', 'C', 'A'],
                    ['A', 'B', 'C', 'B'],
                    ['A', 'B', 'C', 'C'],
                    ['A', 'C', 'A', 'A'],
                    ['A', 'C', 'A', 'B'],
                    ['A', 'C', 'A', 'C'],
                    ['A', 'C', 'B', 'A'],
                    ['A', 'C', 'B', 'B'],
                    ['A', 'C', 'B', 'C'],
                    ['A', 'C', 'C', 'A'],
                    ['A', 'C', 'C', 'B'],
                    ['A', 'C', 'C', 'C'],
                    ['B', 'A', 'A', 'A'],
                    ['B', 'A', 'A', 'B'],
                    ['B', 'A', 'A', 'C'],
                    ['B', 'A', 'B', 'A'],
                    ['B', 'A', 'B', 'B'],
                    ['B', 'A', 'B', 'C'],
                    ['B', 'A', 'C', 'A'],
                    ['B', 'A', 'C', 'B'],
                    ['B', 'A', 'C', 'C'],
                    ['B', 'B', 'A', 'A'],
                    ['B', 'B', 'A', 'B'],
                    ['B', 'B', 'A', 'C'],
                    ['B', 'B', 'B', 'A'],
                    ['B', 'B', 'B', 'B'],
                    ['B', 'B', 'B', 'C'],
                    ['B', 'B', 'C', 'A'],
                    ['B', 'B', 'C', 'B'],
                    ['B', 'B', 'C', 'C'],
                    ['B', 'C', 'A', 'A'],
                    ['B', 'C', 'A', 'B'],
                    ['B', 'C', 'A', 'C'],
                    ['B', 'C', 'B', 'A'],
                    ['B', 'C', 'B', 'B'],
                    ['B', 'C', 'B', 'C'],
                    ['B', 'C', 'C', 'A'],
                    ['B', 'C', 'C', 'B'],
                    ['B', 'C', 'C', 'C'],
                    ['C', 'A', 'A', 'A'],
                    ['C', 'A', 'A', 'B'],
                    ['C', 'A', 'A', 'C'],
                    ['C', 'A', 'B', 'A'],
                    ['C', 'A', 'B', 'B'],
                    ['C', 'A', 'B', 'C'],
                    ['C', 'A', 'C', 'A'],
                    ['C', 'A', 'C', 'B'],
                    ['C', 'A', 'C', 'C'],
                    ['C', 'B', 'A', 'A'],
                    ['C', 'B', 'A', 'B'],
                    ['C', 'B', 'A', 'C'],
                    ['C', 'B', 'B', 'A'],
                    ['C', 'B', 'B', 'B'],
                    ['C', 'B', 'B', 'C'],
                    ['C', 'B', 'C', 'A'],
                    ['C', 'B', 'C', 'B'],
                    ['C', 'B', 'C', 'C'],
                    ['C', 'C', 'A', 'A'],
                    ['C', 'C', 'A', 'B'],
                    ['C', 'C', 'A', 'C'],
                    ['C', 'C', 'B', 'A'],
                    ['C', 'C', 'B', 'B'],
                    ['C', 'C', 'B', 'C'],
                    ['C', 'C', 'C', 'A'],
                    ['C', 'C', 'C', 'B'],
                    ['C', 'C', 'C', 'C'],
                ],
            ],
        ];
    }
}
