<?php

declare(strict_types=1);

namespace Blibio\Combinatorics\Combination;

use Blibio\Combinatorics\AbstractStrategy;

/**
 * @template T
 *
 * @extends AbstractStrategy<T>
 */
final readonly class WithRepetition extends AbstractStrategy
{
    #[\Override]
    protected function next(array $elements, int $i): array
    {
        return \array_slice($elements, $i);
    }

    #[\Override]
    public function count(): int
    {
        /** @var int<0, max> */
        return gmp_intval(
            gmp_div(
                gmp_fact(gmp_sub(gmp_add($this->n, $this->k), 1)),
                gmp_mul(gmp_fact($this->k), gmp_fact(gmp_sub($this->n, 1)))
            )
        );
    }
}
