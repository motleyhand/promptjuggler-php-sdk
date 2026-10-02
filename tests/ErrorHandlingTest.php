<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\FnStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PromptJuggler\Client\Exception\ApiException;
use PromptJuggler\Client\Exception\DecodeException;
use PromptJuggler\Client\Exception\NetworkException;
use PromptJuggler\Client\PromptJuggler;
use RuntimeException;

final class ErrorHandlingTest extends SdkTestCase
{
    public function testApiErrorBecomesSdkApiExceptionWithStatusCode(): void
    {
        $pj = $this->client('sk-test', [new Response(404, ['Content-Type' => 'application/json'], json_encode([
            'error' => 'not found',
        ], JSON_THROW_ON_ERROR))]);

        try {
            $pj->getPromptRun('missing');
            self::fail('Expected ApiException to be thrown');
        } catch (ApiException $e) {
            self::assertSame(404, $e->statusCode);
        }
    }

    public function testApiErrorExposesTheServerErrorMessage(): void
    {
        $pj = $this->client('sk-test', [new Response(403, ['Content-Type' => 'application/json'], json_encode([
            'error' => 'Quota exceeded',
        ], JSON_THROW_ON_ERROR))]);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Quota exceeded');
        $pj->getPromptRun('run_1');
    }

    public function testApiErrorExposesTheServerErrorMessageForAnyStatus(): void
    {
        $pj = $this->client('sk-test', [new Response(404, ['Content-Type' => 'application/json'], json_encode([
            'error' => 'Prompt run not found',
        ], JSON_THROW_ON_ERROR))]);

        try {
            $pj->getPromptRun('missing');
            self::fail('Expected ApiException to be thrown');
        } catch (ApiException $e) {
            self::assertSame('Prompt run not found', $e->getMessage());
        }
    }

    public function testUndecodableSuccessBodyBecomesDecodeException(): void
    {
        $pj = $this->client('sk-test', [self::rawJsonResponse('{"id":')]);

        $this->expectException(DecodeException::class);
        $this->expectExceptionMessage('The API returned invalid JSON: ');
        $pj->getPrompt('greeting', 'production');
    }

    public function testMistypedEnumInSuccessBodyBecomesDecodeException(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['status' => ['pending']] + self::promptRunJson())]);

        $this->expectException(DecodeException::class);
        $this->expectExceptionMessage('status: ');
        $pj->getPromptRun('run_1');
    }

    public function testEmptySuccessBodyBecomesDecodeException(): void
    {
        $pj = $this->client('sk-test', [new Response(200)]);

        $this->expectException(DecodeException::class);
        $pj->getPromptRun('run_1');
    }

    public function testMissingRequiredFieldBecomesDecodeExceptionNamingThePath(): void
    {
        $run = self::workflowRunJson();
        unset($run['outputs']);
        $pj = $this->client('sk-test', [self::jsonResponse($run)]);

        $this->expectException(DecodeException::class);
        $this->expectExceptionMessageMatches('/\boutputs: /');
        $pj->getWorkflowRun('wfr_1');
    }

    /**
     * @param array<string, mixed> $override
     */
    #[DataProvider('wrongTypes')]
    public function testWrongTypedFieldBecomesDecodeExceptionNamingThePath(array $override, string $path): void
    {
        $pj = $this->client(
            'sk-test',
            [self::jsonResponse(array_replace_recursive(self::workflowRunJson(), $override))],
        );

        $this->expectException(DecodeException::class);
        $this->expectExceptionMessage("{$path}: ");
        $pj->getWorkflowRun('wfr_1');
    }

    /**
     * Scalars are never cast: a value of the wrong JSON type fails instead of being normalized.
     *
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function wrongTypes(): iterable
    {
        yield 'array in a string map' => [['outputs' => ['a' => ['x']]], 'outputs.a'];
        yield 'number in a string map' => [['outputs' => ['a' => 7]], 'outputs.a'];
        yield 'number for a string' => [['id' => 123], 'id'];
        yield 'number for an enum' => [['status' => 5], 'status'];
        yield 'numeric string for an integer' => [['tokenUsage' => ['input' => '120']], 'tokenUsage.input'];
        yield 'boolean in a string list' => [['errors' => [true]], 'errors.0'];
    }

    /**
     * @param Closure(PromptJuggler): mixed $call
     */
    #[DataProvider('calls')]
    public function testUnreadableErrorBodyKeepsTheErrorStatus(Closure $call): void
    {
        $pj = $this->client(
            'sk-test',
            [new Response(502, ['Content-Type' => 'text/html'], '<html>Bad Gateway</html>')],
        );

        try {
            $call($pj);
            self::fail('Expected ApiException to be thrown');
        } catch (ApiException $e) {
            self::assertSame(502, $e->statusCode);
            self::assertSame('502 Bad Gateway', $e->getMessage());
        }
    }

    /**
     * @return iterable<string, array{Closure(PromptJuggler): mixed}>
     */
    public static function calls(): iterable
    {
        yield 'uploadDocuments' => [static fn (PromptJuggler $pj): array => $pj->uploadDocuments('docs', [
            'notes.txt' => 'hello',
        ])];
        yield 'getPromptRun' => [static fn (PromptJuggler $pj): object => $pj->getPromptRun('run_1')];
    }

    public function testConnectionFailureBecomesNetworkException(): void
    {
        $pj = $this->client('sk-test', [new ConnectException('Connection refused', new Request('GET', '/'))]);

        $this->expectException(NetworkException::class);
        $pj->getPromptRun('run_1');
    }

    #[DataProvider('statuses')]
    public function testBodyReadFailureBecomesNetworkException(int $status): void
    {
        $fail = static fn (): never => throw new RuntimeException('Connection reset by peer');
        $body = FnStream::decorate(Utils::streamFor('{"error":"not found"}'), [
            '__toString' => $fail,
            'getContents' => $fail,
            'read' => $fail,
        ]);
        $pj = $this->client('sk-test', [new Response($status, ['Content-Type' => 'application/json'], $body)]);

        $this->expectException(NetworkException::class);
        $this->expectExceptionMessage('Connection reset by peer');
        $pj->getPromptRun('run_1');
    }

    /**
     * @return iterable<string, array{int}>
     */
    public static function statuses(): iterable
    {
        yield 'success' => [200];
        yield 'error' => [404];
    }

    public function testErrorStatusBecomesApiExceptionEvenWithAGuzzleClientThatThrowsOnIt(): void
    {
        $pj = new PromptJuggler('sk-test', new Client([
            'handler' => HandlerStack::create(new MockHandler([
                new Response(404, ['Content-Type' => 'application/json'], '{"error":"not found"}'),
            ])),
            'http_errors' => true,
        ]));

        try {
            $pj->getPromptRun('missing');
            self::fail('Expected ApiException to be thrown');
        } catch (ApiException $e) {
            self::assertSame(404, $e->statusCode);
        }
    }

    public function testInputThatIsNotValidUtf8IsRejectedBeforeSending(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::createdRunJson())]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot encode the request as JSON: ');

        try {
            $pj->runPrompt('greeting', 1, inputs: ['topic' => "\xB1\x31"]);
        } finally {
            self::assertSame([], $this->history);
        }
    }
}
