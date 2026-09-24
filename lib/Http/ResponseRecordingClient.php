<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * The Guzzle client Kiota sends through (it only calls send()). Keeps the last response:
 * Kiota's exceptions drop its status when the body is unreadable, and its body when the
 * status has no error mapping.
 *
 * @internal
 */
final class ResponseRecordingClient implements ClientInterface
{
    private ?ResponseInterface $lastResponse = null;

    public function __construct(
        private readonly ClientInterface $inner,
    ) {
    }

    public function lastResponse(): ?ResponseInterface
    {
        return $this->lastResponse;
    }

    public function forget(): void
    {
        $this->lastResponse = null;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        // Kiota reads error statuses itself; a client that throws on them (Guzzle's default) bypasses it.
        return $this->lastResponse = $this->inner->send($request, ['http_errors' => false] + $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function sendAsync(RequestInterface $request, array $options = []): PromiseInterface
    {
        return $this->inner->sendAsync($request, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function request(string $method, $uri, array $options = []): ResponseInterface
    {
        return $this->inner->request($method, $uri, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function requestAsync(string $method, $uri, array $options = []): PromiseInterface
    {
        return $this->inner->requestAsync($method, $uri, $options);
    }

    public function getConfig(?string $option = null): mixed
    {
        return $this->inner->getConfig($option);
    }
}
