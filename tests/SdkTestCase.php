<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PromptJuggler\Client\PromptJuggler;
use Psr\Http\Message\RequestInterface;

abstract class SdkTestCase extends TestCase
{
    /** @var list<array{request: RequestInterface}> */
    protected array $history = [];

    /**
     * Build a facade whose HTTP layer is a Guzzle MockHandler returning the given
     * canned responses, recording every outgoing request into $this->history.
     *
     * @param list<Response> $responses
     */
    protected function client(string $apiKey, array $responses): PromptJuggler
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $stack->push(Middleware::history($this->history));

        return new PromptJuggler($apiKey, new Client(['handler' => $stack]));
    }

    protected function lastRequest(): RequestInterface
    {
        return $this->history[array_key_last($this->history)]['request'];
    }

    /** @return array<string, mixed> */
    protected function jsonBody(RequestInterface $request): array
    {
        return json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }

    /** @param array<string, mixed> $data */
    protected static function jsonResponse(array $data): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], (string) json_encode($data));
    }
}
