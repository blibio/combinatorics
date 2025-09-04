<?php
declare(strict_types=1);

namespace Blibio\Combinatorics\Combination;

use Blibio\Combinatorics\AbstractStrategy;
use InvalidArgumentException;
use Override;
use function array_slice;

/**
 * @template T
 * @extends AbstractStrategy<T>
 */
final readonly class WithoutRepetition extends AbstractStrategy
{
    #[Override]
    protected function assertValid(): void
    {
        parent::assertValid();
        
        if ($this->n < $this->k) {
            throw new InvalidArgumentException("\$k ({$this->k}) must not be greater than number of elements ({$this->n})");
        }
    }

    #[Override]
    protected function next(array $elements, int $i): array
    {
        return array_slice($elements, $i + 1);
    }

    #[Override]
    public function count(): int
    {
        /** @var int<0, max> */
        return gmp_intval(
            gmp_div(
                gmp_fact($this->n),
                gmp_mul(gmp_fact($this->k), gmp_fact(gmp_sub($this->n, $this->k)))
            )
        );
    }
}
