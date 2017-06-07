<?php declare(strict_types=1);

namespace ApiClients\Middleware\HeaderCollector;

final class HeadersRegistry
{
    /**
     * @var Headers[]
     */
    private $sets = [];

    public function get(string $set): Headers
    {
        if (!isset($this->sets[$set])) {
            $this->sets[$set] = new Headers();
        }

        return $this->sets[$set];
    }

    public function getAll(): array
    {
        return $this->sets;
    }
}
