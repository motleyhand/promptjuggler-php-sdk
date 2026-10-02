<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\HttpFactory;
use PromptJuggler\Client\Exception\NetworkException;
use PromptJuggler\Client\PromptJuggler;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

final class ClientOptionsTest extends SdkTestCase
{
    public function testDefaultsToThePromptJugglerHost(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::promptRunJson())]);

        $pj->getPromptRun('run_1');

        self::assertSame('https://promptjuggler.com/api/v1/promptruns/run_1', (string) $this->lastRequest()->getUri());
    }

    public function testHonoursABaseUrl(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::promptRunJson())], 'http://localhost:8888/');

        $pj->getPromptRun('run_1');

        self::assertSame('http://localhost:8888/api/v1/promptruns/run_1', (string) $this->lastRequest()->getUri());
    }

    public function testKeepsTheBaseUrlPathPrefix(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::promptRunJson())], 'https://gateway.example.com/pj');

        $pj->getPromptRun('run_1');

        self::assertSame(
            'https://gateway.example.com/pj/api/v1/promptruns/run_1',
            (string) $this->lastRequest()->getUri(),
        );
    }

    public function testReadsTheBodyFromItsStartWhenMiddlewareAlreadyReadIt(): void
    {
        $stack = HandlerStack::create(new MockHandler([self::jsonResponse(self::promptRunJson())]));
        // Like Guzzle's log middleware with `{res_body}`.
        $stack->push(Middleware::mapResponse(static function (ResponseInterface $response): ResponseInterface {
            $response->getBody()->getContents();

            return $response;
        }));
        $pj = new PromptJuggler('sk-test', new Client(['handler' => $stack]));

        self::assertSame('Hello there!', $pj->getPromptRun('run_1')->output);
    }

    public function testDiscoversAnInstalledHttpClientWhenNoneIsGiven(): void
    {
        // Nothing listens on port 1, so the discovered client fails to connect.
        $pj = new PromptJuggler('sk-test', baseUrl: 'http://127.0.0.1:1');

        $this->expectException(NetworkException::class);
        $pj->getPromptRun('run_1');
    }

    public function testBuildsRequestsWithAClientThatIsAlsoAFactory(): void
    {
        // Like Symfony's Psr18Client, which implements PSR-17 too.
        $http = new class([
            self::jsonResponse(self::promptRunJson()),
        ]) implements ClientInterface, RequestFactoryInterface, StreamFactoryInterface {
            /** @var list<string> */
            public array $created = [];
            private readonly Client $client;
            private readonly HttpFactory $factory;

            /** @param list<ResponseInterface> $responses */
            public function __construct(array $responses)
            {
                $this->client = new Client(['handler' => HandlerStack::create(new MockHandler($responses))]);
                $this->factory = new HttpFactory();
            }

            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                return $this->client->sendRequest($request);
            }

            public function createRequest(string $method, $uri): RequestInterface
            {
                $this->created[] = "{$method} {$uri}";

                return $this->factory->createRequest($method, $uri);
            }

            public function createStream(string $content = ''): StreamInterface
            {
                return $this->factory->createStream($content);
            }

            public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
            {
                return $this->factory->createStreamFromFile($filename, $mode);
            }

            public function createStreamFromResource($resource): StreamInterface
            {
                return $this->factory->createStreamFromResource($resource);
            }
        };

        (new PromptJuggler('sk-test', $http))->getPromptRun('run_1');

        self::assertSame(['GET https://promptjuggler.com/api/v1/promptruns/run_1'], $http->created);
    }
}
