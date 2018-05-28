<?php
declare(strict_types=1);

namespace Meek\Collection;

use OverflowException;
use UnderflowException;

/**
 * A 'bounded' stack contains a finite number of items. It also throws exceptions when a boundary is reached.
 */
class BoundedStack extends Stack
{
    /**
     * The maximum number of items that can be stored.
     * @var integer
     */
    private $maxSize;

    /**
     * Create a bounded stack.
     * @param integer $maxSize The maximum number of items that can be stored.
     * @param mixed[] $items First item passed as argument will be the last out.
     */
    public function __construct(int $maxSize, ...$items)
    {
        $this->maxSize = $maxSize;

        while ($item = array_shift($items)) {
            $this->push($item);
        }
    }

    /**
     * {@inheritdoc}
     * @throws OverflowException If adding an element will exceed self::$maxSize.
     */
    public function push($item): void
    {
        if ($this->size() === $this->maxSize) {
            throw new OverflowException('Stack has reached max size');
        }

        parent::push($item);
    }

    /**
     * {@inheritdoc}
     * @throws UnderflowException If trying to remove an item from an empty stack.
     */
    public function pop()
    {
        $item = parent::pop();

        if ($item === null) {
            throw new UnderflowException('Stack is empty');
        }

        return $item;
    }

    /**
     * Retrieve the maximum size of the stack.
     * @return integer The maximum number of items that can be stored.
     */
    public function getMaxSize(): int
    {
        return $this->maxSize;
    }
}
