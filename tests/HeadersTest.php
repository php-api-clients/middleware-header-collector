<?php declare(strict_types=1);

namespace ApiClients\Tests\Middleware\HeaderCollector;

use ApiClients\Middleware\HeaderCollector\Headers;
use ApiClients\Tools\TestUtilities\TestCase;

/**
 * @internal
 */
final class HeadersTest extends TestCase
{
    public function testStream(): void
    {
        $items = [];
        $item = ['foo' => 'bar'];
        $stream = new Headers();
        $stream->subscribe(function ($item) use (&$items): void {
            $items[] = $item;
        });
        $stream->onNext($item);
        self::assertSame([$item], $items);
    }
}
