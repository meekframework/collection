<?php
declare(strict_types=1);

namespace Meek\Collection;

use PHPUnit\Framework\TestCase;
use Throwable;
use Closure;

abstract class TestSuite extends TestCase
{
    /**
     * [assertThrows description]
     * @param Throwable $expectedException [description]
     * @param Closure $callback [description]
     */
    final public function assertThrows(Throwable $expectedException, Closure $callback): void
    {
        $actualException = null;

        try {
            call_user_func($callback);
        } catch (Throwable $thrownException) {
            $actualException = $thrownException;
        }

        $this->assertNotNull($actualException, 'An exception was not thrown');
        $this->assertEquals($expectedException, $actualException);
    }
}
