<?php
declare(strict_types=1);

namespace Blibio\Combinatorics;

use InvalidArgumentException;

final readonly class Combinatorics
{
    /**
     * @template U
     * @param array<array-key, U> $elements
     * @param int<1, max> $k
     * @return Combination\WithRepetition<U>
     *
     * @throws InvalidArgumentException
     */
    public static function combinationsWithRepetition(array $elements, int $k): Combination\WithRepetition
    {
        return new Combination\WithRepetition($elements, $k);
    }

    /**
     * @template U
     * @param array<array-key, U> $elements
     * @param int<1, max> $k
     * @return Combination\WithoutRepetition<U>
     *
     * @throws InvalidArgumentException
     */
    public static function combinationsWithoutRepetition(array $elements, int $k): Combination\WithoutRepetition
    {
        return new Combination\WithoutRepetition($elements, $k);
    }

    /**
     * @template U
     * @param array<array-key, U> $elements
     * @param int<1, max> $k
     * @return Permutation\WithRepetition<U>
     *
     * @throws InvalidArgumentException
     */
    public static function permutationsWithRepetition(array $elements, int $k): Permutation\WithRepetition
    {
        return new Permutation\WithRepetition($elements, $k);
    }

    /**
     * @template U
     * @param array<array-key, U> $elements
     * @param int<1, max> $k
     * @return Permutation\WithoutRepetition<U>
     *
     * @throws InvalidArgumentException
     */
    public static function permutationsWithoutRepetition(array $elements, int $k): Permutation\WithoutRepetition
    {
        return new Permutation\WithoutRepetition($elements, $k);
    }
}
