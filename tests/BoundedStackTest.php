<?php
declare(strict_types=1);

namespace Meek\Collection;

use OverflowException;
use UnderflowException;

class BoundedStackTest extends StackTest
{
    public function createEmptyStack(): Stack
    {
        return new BoundedStack(5);
    }

    /**
     * @test
     */
    public function max_size_is_set()
    {
        $stack = new BoundedStack(5);

        $maxSize = $stack->getMaxSize();

        $this->assertEquals(5, $maxSize);
    }

    /**
     * @test
     */
    public function throws_exception_if_trying_to_push_item_to_full_stack()
    {
        $expectedException = new OverflowException('Stack has reached max size');
        $stack = new BoundedStack(1);
        $stack->push(new class {});

        $callback = function () use ($stack) {
            $stack->push(new class {});
        };

        $this->assertThrows($expectedException, $callback);
    }

    /**
     * @test
     */
    public function throws_exception_if_trying_to_pop_item_from_empty_stack()
    {
        $expectedException = new UnderflowException('Stack is empty');
        $stack = new BoundedStack(1);

        $callback = function () use ($stack) {
            $item = $stack->pop();
        };

        $this->assertThrows($expectedException, $callback);
    }

    /**
     * @test
     */
    public function items_passed_during_initialisation_are_pushed_onto_stack()
    {
        $stack = new BoundedStack(5, 'd', 'o', 'g');

        $this->assertEquals('g', $stack->pop());
        $this->assertEquals('o', $stack->pop());
        $this->assertEquals('d', $stack->pop());
    }
}
