<?php

declare(strict_types=1);

namespace Blibio\Combinatorics\Test;

use Blibio\Combinatorics\AbstractStrategy;
use PHPUnit\Framework\TestCase;

/**
 * Tests for AbstractStrategy algorithmic and behavioral concerns
 * These tests apply to all concrete strategy implementations.
 */
final class AbstractStrategyTest extends TestCase
{
    /**
     * @template U
     *
     * @param array<array-key, U> $elements
     * @param int<1, max>         $k
     *
     * @return TestableStrategy<U>
     */
    private function createTestableStrategy(array $elements, int $k): TestableStrategy
    {
        return new TestableStrategy($elements, $k);
    }

    public function testGenerateProducesExpectedResults(): void
    {
        $strategy = $this->createTestableStrategy(['A', 'B', 'C'], 2);

        $results = [];
        foreach ($strategy as $combo) {
            $results[] = $combo;
        }

        $expected = [
            ['A', 'B'],
            ['A', 'C'],
            ['B', 'C'],
        ];

        self::assertEquals($expected, $results);
        self::assertCount(3, $results);
    }

    // === Validation Tests (Base Class Logic) ===

    public function testThrowsOnEmptyArray(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot generate combinations/permutations from empty array.');

        $this->createTestableStrategy([], 1);
    }

    public function testThrowsOnNumLessThanZero(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$k must be greater than zero, got: -1');

        /** @phpstan-ignore argument.type */
        $this->createTestableStrategy(['A'], -1);
    }

    // === Algorithmic/Behavioral Tests ===

    public function testIteratorReusability(): void
    {
        $strategy = $this->createTestableStrategy(['A', 'B'], 1);

        // First iteration
        $firstPass = [];
        foreach ($strategy as $combo) {
            $firstPass[] = $combo;
        }

        // Second iteration on iterator
        $secondPass = [];
        foreach ($strategy as $combo) {
            $secondPass[] = $combo;
        }

        self::assertEquals($firstPass, $secondPass);
        self::assertEquals([['A'], ['B']], $firstPass);
    }

    public function testDuplicateElementsAreTreatedAsDistinct(): void
    {
        // Each array position is treated as a distinct identity
        $strategy = $this->createTestableStrategy(['A', 'A', 'B'], 2);

        $results = [];
        foreach ($strategy as $combo) {
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

    public function testIteratorToArrayPreservesAllResults(): void
    {
        $strategy = $this->createTestableStrategy(['A', 'B', 'C'], 2);

        // Using iterator_to_array with preserve_keys = true should preserve all results
        $arrayResults = iterator_to_array($strategy, true);

        // Expected: 3 combinations
        $expected = [
            ['A', 'B'],
            ['A', 'C'],
            ['B', 'C'],
        ];

        // This should have all 3 results, not just the last one
        self::assertCount(3, $arrayResults);
        self::assertEquals($expected, array_values($arrayResults));
    }
}

/**
 * Simple mock implementation for testing AbstractStrategy behavior.
 * Uses basic "combination without repetition" logic for simplicity.
 *
 * @template T
 *
 * @extends AbstractStrategy<T>
 */
final readonly class TestableStrategy extends AbstractStrategy
{
    #[\Override]
    protected function next(array $elements, int $i): array
    {
        return \array_slice($elements, $i + 1);
    }

    #[\Override]
    public function count(): int
    {
        // Simple combination formula for testing
        /** @var int<0, max> */
        return gmp_intval(
            gmp_div(
                gmp_fact($this->n),
                gmp_mul(gmp_fact($this->k), gmp_fact(gmp_sub($this->n, $this->k)))
            )
        );
    }
}
