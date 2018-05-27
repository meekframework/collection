<?php
declare(strict_types=1);

namespace Meek\Collection;

class UnboundedStackTest extends StackTest
{
    public function createEmptyStack(): Stack
    {
        return new UnboundedStack();
    }

    /**
     * @test
     */
    public function items_passed_during_initialisation_are_pushed_onto_stack()
    {
        $stack = new UnboundedStack('d', 'o', 'g');

        $this->assertEquals('g', $stack->pop());
        $this->assertEquals('o', $stack->pop());
        $this->assertEquals('d', $stack->pop());
    }
}
