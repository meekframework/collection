<?php
declare(strict_types=1);

namespace Meek\Collection;

/**
 * An 'unbounded' stack can contain an infinite number of items.
 */
class UnboundedStack extends Stack
{
    /**
     * Create an unbounded stack.
     * @param mixed[] $items First item passed as argument will be the last out.
     */
    public function __construct(...$items)
    {
        while ($item = array_shift($items)) {
            $this->push($item);
        }
    }
}
