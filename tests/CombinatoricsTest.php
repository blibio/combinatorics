<?php

declare(strict_types=1);

namespace Blibio\Combinatorics\Test;

use Blibio\Combinatorics\Combination;
use Blibio\Combinatorics\Combinatorics;
use Blibio\Combinatorics\Permutation;
use PHPUnit\Framework\TestCase;

final class CombinatoricsTest extends TestCase
{
    public function testCombinationsWithRepetitionFromFlag(): void
    {
        $elements = ['A', 'B'];
        $k = 2;

        $result = Combinatorics::combinations($elements, $k, withRepetition: true);
        $expected = Combinatorics::combinationsWithRepetition($elements, $k);

        self::assertEquals(iterator_to_array($expected), iterator_to_array($result));
        self::assertInstanceOf(Combination\WithRepetition::class, $result);
    }

    public function testCombinationsWithoutRepetitionFromFlag(): void
    {
        $elements = ['A', 'B', 'C'];
        $k = 2;

        $result = Combinatorics::combinations($elements, $k, withRepetition: false);
        $expected = Combinatorics::combinationsWithoutRepetition($elements, $k);

        self::assertEquals(iterator_to_array($expected), iterator_to_array($result));
        self::assertInstanceOf(Combination\WithoutRepetition::class, $result);
    }

    public function testPermutationsWithRepetitionFromFlag(): void
    {
        $elements = ['A', 'B'];
        $k = 2;

        $result = Combinatorics::permutations($elements, $k, withRepetition: true);
        $expected = Combinatorics::permutationsWithRepetition($elements, $k);

        self::assertEquals(iterator_to_array($expected), iterator_to_array($result));
        self::assertInstanceOf(Permutation\WithRepetition::class, $result);
    }

    public function testPermutationsWithoutRepetitionFromFlag(): void
    {
        $elements = ['A', 'B', 'C'];
        $k = 2;

        $result = Combinatorics::permutations($elements, $k, withRepetition: false);
        $expected = Combinatorics::permutationsWithoutRepetition($elements, $k);

        self::assertEquals(iterator_to_array($expected), iterator_to_array($result));
        self::assertInstanceOf(Permutation\WithoutRepetition::class, $result);
    }
}
