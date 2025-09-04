<?php
declare(strict_types=1);

namespace Blibio\Combinatorics\Permutation;

use Blibio\Combinatorics\AbstractStrategy;
use Override;

/**
 * @template T
 * @extends AbstractStrategy<T>
 */
final class WithRepetition extends AbstractStrategy
{
    #[Override]
    protected function next(array $elements, int $i): array
    {
        return $elements;
    }

    #[Override]
    public function count(): int
    {
        /** @var int<0, max> */
        return gmp_intval(gmp_pow($this->n, $this->k));
    }
}
