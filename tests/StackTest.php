<?php
declare(strict_types=1);

namespace Meek\Collection;

use Countable;
use stdClass;
use InvalidArgumentException;
use UnderflowException;

abstract class StackTest extends TestSuite
{
    abstract public function createEmptyStack(): Stack;

    /**
     * @test
     */
    public function can_be_counted()
    {
        $stack = $this->createEmptyStack();

        $this->assertInstanceOf(Countable::class, $stack);
    }

    /**
     * @test
     */
    public function has_initial_size_of_zero()
    {
        $stack = $this->createEmptyStack();

        $size = $stack->size();

        $this->assertEquals(0, $size);
    }

    /**
     * @test
     */
    public function has_initial_count_of_zero()
    {
        $stack = $this->createEmptyStack();

        $count = count($stack);

        $this->assertEquals(0, $count);
    }

    /**
     * @test
     */
    public function throws_exception_if_item_does_not_match_data_type_from_first_item_pushed_on()
    {
        $expectedException = new InvalidArgumentException('Item is not an instance of "stdClass"');
        $item = new stdClass();
        $stack = $this->createEmptyStack();

        $stack->push($item);

        $callback = function () use ($stack) {
            $stack->push(new class {});
        };

        $this->assertThrows($expectedException, $callback);
    }

    /**
     * @test
     */
    public function item_is_pushed_on_top_if_matches_set_data_type()
    {
        $expectedItem = new stdClass();
        $stack = $this->createEmptyStack();

        $stack->push($expectedItem);
        $actualItem = $stack->peek();

       $this->assertSame($expectedItem, $actualItem);
    }

    /**
     * @test
     */
    public function can_handle_scalar_types()
    {
        $actualValue = '';
        $stack = $this->createEmptyStack();
        $stack->push('d');
        $stack->push('o');
        $stack->push('g');

        $actualValue .= $stack->pop();
        $actualValue .= $stack->pop();
        $actualValue .= $stack->pop();

        $this->assertEquals('god', $actualValue);
    }

    /**
     * @test
     */
    public function pushing_item_increases_size()
    {
        $stack = $this->createEmptyStack();
        $stack->push(new stdClass());
        $stack->push(new stdClass());

        $size = $stack->size();

        $this->assertEquals(2, $size);
    }

    /**
     * @test
     */
    public function pushing_item_increases_count()
    {
        $stack = $this->createEmptyStack();
        $stack->push(new stdClass());
        $stack->push(new stdClass());

        $count = count($stack);

        $this->assertEquals(2, $count);
    }

    /**
     * @test
     */
    public function throws_exception_if_trying_to_pop_item_from_empty_collection()
    {
        $expectedException = new UnderflowException('Stack is empty');
        $stack = $this->createEmptyStack();

        $callback = function () use ($stack) {
            $item = $stack->pop();
        };

        $this->assertThrows($expectedException, $callback);
    }

    /**
     * @test
     */
    public function popping_item_removes_last_item_pushed()
    {
        $itemOne = new stdClass();
        $expectedItem = new stdClass();
        $stack = $this->createEmptyStack();
        $stack->push($itemOne);
        $stack->push($expectedItem);

        $actualItem = $stack->pop();

        $this->assertSame($expectedItem, $actualItem);
        $this->assertSame($itemOne, $stack->peek());
    }

    /**
     * @test
     */
    public function popping_item_decreases_size()
    {
        $stack = $this->createEmptyStack();
        $stack->push(new stdClass());
        $stack->push(new stdClass());

        $item = $stack->pop();
        $size = $stack->size();

        $this->assertEquals(1, $size);
    }

    /**
     * @test
     */
    public function popping_item_decreases_count()
    {
        $stack = $this->createEmptyStack();
        $stack->push(new stdClass());
        $stack->push(new stdClass());

        $item = $stack->pop();
        $count = count($stack);

        $this->assertEquals(1, $count);
    }

    /**
     * @test
     */
    public function peeking_at_top_element_returns_null_if_collection_is_empty()
    {
        $stack = $this->createEmptyStack();

        $item = $stack->peek();

        $this->assertNull($item);
    }
}
