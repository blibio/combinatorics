<?php

declare(strict_types=1);

namespace Blibio\Combinatorics;

/**
 * @template T
 *
 * @implements \IteratorAggregate<int, list<T>>
 */
abstract readonly class AbstractStrategy implements \Countable, \IteratorAggregate
{
    /** @var list<T> */
    protected array $elements;

    /** @var int<0, max> */
    protected int $n;

    /** @var int<1, max> */
    protected int $k;

    /**
     * @param array<array-key, T> $elements
     * @param int<1, max>         $k
     *
     * @throws \InvalidArgumentException
     */
    final public function __construct(array $elements, int $k)
    {
        if ($k < 1) {
            throw new \InvalidArgumentException("\$k must be greater than zero, got: $k");
        }

        $this->elements = array_values($elements);
        $this->n = \count($this->elements);
        $this->k = $k;

        $this->assertValid();
    }

    protected function assertValid(): void
    {
        if (0 === $this->n) {
            throw new \InvalidArgumentException('Cannot generate combinations/permutations from empty array.');
        }
    }

    /**
     * @param list<T> $elements
     *
     * @return list<T>
     */
    abstract protected function next(array $elements, int $i): array;

    /**
     * @param list<T>       $elements
     * @param array<int, T> $result
     *
     * @return iterable<int, list<T>>
     */
    final protected function generate(array $elements, int $slot = 0, array &$result = [], int &$index = 0): iterable
    {
        $nextSlot = $slot + 1;

        foreach ($elements as $i => $element) {
            /** @var list<T> $result */
            $result[$slot] = $element;

            if ($nextSlot < $this->k) {
                yield from $this->generate($this->next($elements, $i), $nextSlot, $result, $index);
            } else {
                yield $index++ => $result;
            }
        }
    }

    final public function getIterator(): \Traversable
    {
        yield from $this->generate($this->elements);
    }
}
