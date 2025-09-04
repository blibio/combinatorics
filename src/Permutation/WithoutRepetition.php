<?php

declare(strict_types=1);

namespace Blibio\Combinatorics\Permutation;

use Blibio\Combinatorics\AbstractStrategy;

/**
 * @template T
 *
 * @extends AbstractStrategy<T>
 */
final readonly class WithoutRepetition extends AbstractStrategy
{
    #[\Override]
    protected function assertValid(): void
    {
        parent::assertValid();

        if ($this->n < $this->k) {
            throw new \InvalidArgumentException("\$k ({$this->k}) must not be greater than number of elements ({$this->n})");
        }
    }

    #[\Override]
    protected function next(array $elements, int $i): array
    {
        array_splice($elements, $i, 1);

        return $elements;
    }

    #[\Override]
    public function count(): int
    {
        /** @var int<0, max> */
        return gmp_intval(
            gmp_div(
                gmp_fact($this->n),
                gmp_fact(gmp_sub($this->n, $this->k))
            )
        );
    }
}
