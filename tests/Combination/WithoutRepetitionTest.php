<?php
declare(strict_types=1);

namespace Blibio\Combinatorics\Test\Combination;

use Blibio\Combinatorics\Combinatorics;
use Countable;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Traversable;

final class WithoutRepetitionTest extends TestCase
{
    public function testThrowsOnEmptyArray(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot generate combinations/permutations from empty array.');

        Combinatorics::combinationsWithoutRepetition([], 1);
    }

    public function testThrowsOnNumLessThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$k must be greater than zero, got: -1');

        /** @phpstan-ignore argument.type */
        Combinatorics::combinationsWithoutRepetition(['A'], -1);
    }

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

    public function testIteratorReusability(): void
    {
        $uut = Combinatorics::combinationsWithoutRepetition(['A', 'B'], 1);
        
        // First iteration
        $firstPass = [];
        foreach ($uut as $combo) {
            $firstPass[] = $combo;
        }
        
        // Second iteration on same object
        $secondPass = [];
        foreach ($uut as $combo) {
            $secondPass[] = $combo;
        }
        
        self::assertEquals($firstPass, $secondPass);
        self::assertEquals([['A'], ['B']], $firstPass);
    }

    public function testDuplicateElementsAreTreatedAsDistinct(): void
    {
        // Each array position is treated as a distinct identity
        $uut = Combinatorics::combinationsWithoutRepetition(['A', 'A', 'B'], 2);
        
        $results = [];
        foreach ($uut as $combo) {
            $results[] = $combo;
        }
        
        // Should get 3 combinations: first-A+second-A, first-A+B, second-A+B
        $expected = [
            ['A', 'A'], // position 0 + position 1
            ['A', 'B'], // position 0 + position 2
            ['A', 'B'], // position 1 + position 2
        ];
        
        self::assertEquals($expected, $results);
        self::assertCount(3, $results);
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
