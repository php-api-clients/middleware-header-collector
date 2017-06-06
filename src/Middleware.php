<?php declare(strict_types=1);

namespace ApiClients\Middleware\HeaderCollector;

use ApiClients\Foundation\Middleware\ErrorTrait;
use ApiClients\Foundation\Middleware\MiddlewareInterface;
use ApiClients\Foundation\Middleware\PreTrait;
use ApiClients\Foundation\Middleware\Priority;
use Psr\Http\Message\ResponseInterface;
use React\Promise\CancellablePromiseInterface;
use function React\Promise\resolve;

final class Middleware implements MiddlewareInterface
{
    use ErrorTrait;
    use PreTrait;

    /**
     * @var Headers
     */
    private $headers;

    /**
     * @param Headers $headers
     */
    public function __construct(Headers $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param  ResponseInterface           $response
     * @param  array                       $options
     * @return CancellablePromiseInterface
     */
    public function post(ResponseInterface $response, array $options = []): CancellablePromiseInterface
    {
        if (isset($options[self::class]) &&
            isset($options[self::class][Options::HEADERS]) &&
            is_array($options[self::class][Options::HEADERS])
        ) {
            $this->extractHeaders($response, $options[self::class][Options::HEADERS]);
        }

        return resolve($response);
    }

    /**
     * @return int
     */
    public function priority(): int
    {
        return Priority::LAST;
    }

    /**
     * @param ResponseInterface $response
     * @param array $headers
     */
    private function extractHeaders(ResponseInterface $response, array $headers)
    {
        $set = [];

        foreach ($headers as $header) {
            if (!$response->hasHeader($header)) {
                continue;
            }

            $set[$header] = $response->getHeaderLine($header);
        }

        if (count($set) === 0) {
            return;
        }

        $this->headers->onNext($set);
    }
}
