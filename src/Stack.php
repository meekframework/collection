<?php
declare(strict_types=1);

namespace Meek\Collection;

use Countable;
use InvalidArgumentException;
use UnderflowException;

/**
 * A stack is a linear data structure that makes use of the LIFO (Last In, First Out) principle.
 */
abstract class Stack implements Countable
{
    /**
     * The data type of the items to store.
     * @var string
     */
    private $dataType;

    /**
     * The fully-qualified class name of the object items must be an instance of.
     * @var string
     */
    private $instanceType;

    /**
     * The items in the stack.
     * @var mixed[]
     */
    private $items = [];

    /**
     * Add an element to the 'top' of the stack.
     * @throws InvalidArgumentException If the item is not the same type as the first item added.
     * @throws InvalidArgumentException If the item is not the same class as the first item added.
     */
    public function push($item): void
    {
        if (is_null($this->dataType)) {
            $this->setDataTypeFromItem($item);
        }

        $this->assertIsCorrectType($item);
        array_push($this->items, $item);
    }

    /**
     * Remove an element from the 'top' of the stack.
     * @throws UnderflowException If trying to remove an item from an empty stack.
     * @return mixed The top-most item in the stack.
     */
    public function pop()
    {
        if (empty($this->items)) {
            throw new UnderflowException('Stack is empty');
        }

        return array_pop($this->items);
    }

    /**
     * Return the top-most item of the stack without modifying it.
     * @return mixed|null The top-most item in the stack or nothing.
     */
    public function peek()
    {
        if (empty($this->items)) {
            return null;
        }

        return $this->items[count($this->items) - 1];
    }

    /**
     * Get the size of the stack.
     * @return integer The number of items in the stack.
     */
    public function size(): int
    {
        return count($this->items);
    }

    /**
     * Count the items in the stack.
     * @return integer The number of items in the stack.
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Determine the data type from an item then make the stack only support adding items of that type only.
     * @param mixed $item The item to be placed on top of the stack.
     */
    private function setDataTypeFromItem($item): void
    {
        $this->dataType = gettype($item);

        if ($this->dataType === 'object') {
            $this->instanceType = get_class($item);
        }
    }

    /**
     * Make sure an item is the same type and class as the first item placed on the stack.
     * @param mixed $item The item to be placed on top of the stack.
     */
    private function assertIsCorrectType($item): void
    {
        $itemDataType = gettype($item);

        if ($itemDataType !== $this->dataType) {
            throw new InvalidArgumentException(sprintf('Item is not an instance of "%s"', $this->dataType));
        }

        if ($itemDataType === 'object' && !($item instanceof $this->instanceType)) {
            throw new InvalidArgumentException(sprintf('Item is not an instance of "%s"', $this->instanceType));
        }
    }
}
