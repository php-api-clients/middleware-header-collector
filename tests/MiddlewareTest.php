<?php declare(strict_types=1);

namespace ApiClients\Tests\Middleware\HeaderCollector;

use ApiClients\Middleware\HeaderCollector\Headers;
use ApiClients\Middleware\HeaderCollector\Middleware;
use ApiClients\Middleware\HeaderCollector\Options;
use ApiClients\Tools\TestUtilities\TestCase;
use RingCentral\Psr7\Response;

final class MiddlewareTest extends TestCase
{
    public function testPost()
    {
        $array = [];
        $headers = new Headers();
        $headers->subscribe(function ($headers) use (&$array) {
            $array[] = $headers;
        });

        $response = new Response(200, ['header' => 'value', 'header2' => 'value2']);
        $options = [
            Middleware::class => [
                Options::HEADERS => [
                    'header',
                ],
            ],
        ];

        $middleware = new Middleware($headers);
        $middleware->post($response, $options);

        self::assertSame([
            ['header' => 'value'],
        ], $array);
    }
}
