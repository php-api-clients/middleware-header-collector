<?php declare(strict_types=1);

namespace ApiClients\Tests\Middleware\HeaderCollector;

use ApiClients\Middleware\HeaderCollector\HeaderCollectorMiddleware;
use ApiClients\Middleware\HeaderCollector\Headers;
use ApiClients\Middleware\HeaderCollector\Options;
use ApiClients\Tools\TestUtilities\TestCase;
use RingCentral\Psr7\Response;

/**
 * @internal
 */
final class HeaderCollectorMiddlewareTest extends TestCase
{
    public function testPost(): void
    {
        $array = [];
        $headers = new Headers();
        $headers->subscribe(function ($headers) use (&$array): void {
            $array[] = $headers;
        });

        $response = new Response(200, ['header' => 'value', 'header2' => 'value2']);
        $options = [
            HeaderCollectorMiddleware::class => [
                Options::HEADERS => [
                    'header',
                ],
            ],
        ];

        $middleware = new HeaderCollectorMiddleware($headers);
        $middleware->post($response, 'abc', $options);

        self::assertSame([
            ['header' => 'value'],
        ], $array);
    }
}
