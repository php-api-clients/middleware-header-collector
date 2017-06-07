<?php declare(strict_types=1);

namespace ApiClients\Tests\Middleware\HeaderCollector;

use ApiClients\Middleware\HeaderCollector\HeadersRegistry;
use ApiClients\Tools\TestUtilities\TestCase;

final class HeadersRegistryTest extends TestCase
{
    public function testGet()
    {
        $registry = new HeadersRegistry();
        self::assertSame([], $registry->getAll());
        $github = $registry->get('github');
        self::assertSame(['github' => $github], $registry->getAll());
        self::assertSame($github, $registry->get('github'));
        $travis = $registry->get('travis');
        self::assertSame(['github' => $github, 'travis' => $travis], $registry->getAll());
        self::assertNotSame($github, $registry->get('travis'));
    }
}
