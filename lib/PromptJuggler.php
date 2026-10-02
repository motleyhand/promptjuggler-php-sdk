<?php

declare(strict_types=1);

namespace PromptJuggler\Client;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Tree\Message\NodeMessage;
use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use Http\Discovery\Psr18Client;
use InvalidArgumentException;
use JsonException;
use PromptJuggler\Client\Exception\ApiException;
use PromptJuggler\Client\Exception\DecodeException;
use PromptJuggler\Client\Exception\NetworkException;
use PromptJuggler\Client\Exception\PromptJugglerException;
use PromptJuggler\Client\Mapping\ModelMapping;
use PromptJuggler\Client\Models\CreatePromptRunResponse;
use PromptJuggler\Client\Models\CreateWorkflowRunResponse;
use PromptJuggler\Client\Models\KnowledgeBaseResponse;
use PromptJuggler\Client\Models\KnowledgeDocumentResponse;
use PromptJuggler\Client\Models\Priority;
use PromptJuggler\Client\Models\PromptRevision;
use PromptJuggler\Client\Models\PromptRun;
use PromptJuggler\Client\Models\StreamTokenResponse;
use PromptJuggler\Client\Models\WorkflowRun;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use SensitiveParameter;

/**
 * Synchronous entry point to the PromptJuggler API: flat methods in, generated readonly models out.
 */
final class PromptJuggler
{
    // Untyped: typed class constants need PHP 8.3.
    public const DEFAULT_BASE_URL = 'https://promptjuggler.com';

    private readonly Psr18Client $http;
    private readonly string $baseUrl;
    private readonly TreeMapper $mapper;

    /**
     * @param ClientInterface|null $httpClient Any PSR-18 client, discovered when omitted. Request
     *                                         factories are discovered too, unless the client is one.
     */
    public function __construct(
        #[SensitiveParameter]
        private readonly string $apiKey,
        ?ClientInterface $httpClient = null,
        string $baseUrl = self::DEFAULT_BASE_URL,
    ) {
        $this->http = new Psr18Client($httpClient);
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->mapper = ModelMapping::configure(
            (new MapperBuilder())
                // The API adds response fields without a version bump.
                ->allowSuperfluousKeys()
                // Free-form payloads are array<string, mixed>.
                ->allowPermissiveTypes()
                ->supportDateFormats('Y-m-d\TH:i:s.uP', 'Y-m-d\TH:i:sP'),
        )->mapper();
    }

    /**
     * @throws PromptJugglerException
     */
    public function getPrompt(string $slug, int|string $version): PromptRevision
    {
        return $this->decode(PromptRevision::class, $this->send($this->request(
            'GET',
            '/api/v1/prompts/' . rawurlencode($slug) . '/' . rawurlencode((string) $version),
        )));
    }

    /**
     * @param array<string, string> $inputs
     * @param array<string, string>|null $envVars
     * @param array<string, string|list<string>>|null $metadata
     * @throws PromptJugglerException
     */
    public function runPrompt(
        string $slug,
        int|string $version,
        array $inputs,
        ?Priority $priority = null,
        ?string $thread = null,
        ?string $environment = null,
        ?array $envVars = null,
        ?array $metadata = null,
        ?string $channel = null,
    ): CreatePromptRunResponse {
        return $this->decode(CreatePromptRunResponse::class, $this->send($this->withJson(
            $this->request(
                'POST',
                '/api/v1/prompts/' . rawurlencode($slug) . '/' . rawurlencode((string) $version) . '/runs',
            ),
            self::withoutNulls([
                ...self::runFields($inputs, $priority, $thread, $environment, $envVars, $metadata),
                'channel' => $channel,
            ]),
        )));
    }

    /**
     * @throws PromptJugglerException
     */
    public function getPromptRun(string $id): PromptRun
    {
        return $this->decode(PromptRun::class, $this->send($this->request(
            'GET',
            '/api/v1/promptruns/' . rawurlencode($id),
        )));
    }

    /**
     * @param array<string, string> $inputs
     * @param array<string, string>|null $envVars
     * @param array<string, string|list<string>>|null $metadata
     * @throws PromptJugglerException
     */
    public function runWorkflow(
        string $slug,
        int|string $version,
        array $inputs,
        ?Priority $priority = null,
        ?string $thread = null,
        ?string $environment = null,
        ?array $envVars = null,
        ?array $metadata = null,
    ): CreateWorkflowRunResponse {
        return $this->decode(CreateWorkflowRunResponse::class, $this->send($this->withJson(
            $this->request(
                'POST',
                '/api/v1/workflows/' . rawurlencode($slug) . '/' . rawurlencode((string) $version) . '/runs',
            ),
            self::withoutNulls(self::runFields($inputs, $priority, $thread, $environment, $envVars, $metadata)),
        )));
    }

    /**
     * @throws PromptJugglerException
     */
    public function getWorkflowRun(string $id): WorkflowRun
    {
        return $this->decode(WorkflowRun::class, $this->send($this->request(
            'GET',
            '/api/v1/workflowruns/' . rawurlencode($id),
        )));
    }

    /**
     * Mint a short-lived, thread-scoped credential for the streaming endpoint. Call this from your
     * server and hand the result to the browser -- the API key must never reach it. The response
     * carries the fully-resolved SSE URL alongside the token, so clients need no host config.
     *
     * Connect before triggering a run: tokens emitted while nobody is subscribed are not replayed.
     *
     * @throws PromptJugglerException
     */
    public function createStreamToken(string $thread): StreamTokenResponse
    {
        return $this->decode(StreamTokenResponse::class, $this->send($this->request(
            'POST',
            '/api/v1/threads/' . rawurlencode($thread) . '/stream-token',
        )));
    }

    /**
     * @throws PromptJugglerException
     */
    public function getKnowledgeBase(string $slug): KnowledgeBaseResponse
    {
        return $this->decode(KnowledgeBaseResponse::class, $this->send($this->request(
            'GET',
            '/api/v1/knowledge-bases/' . rawurlencode($slug),
        )));
    }

    /**
     * @throws PromptJugglerException
     */
    public function getKnowledgeDocument(string $id): KnowledgeDocumentResponse
    {
        return $this->decode(KnowledgeDocumentResponse::class, $this->send($this->request(
            'GET',
            '/api/v1/knowledge-documents/' . rawurlencode($id),
        )));
    }

    /**
     * @throws PromptJugglerException
     */
    public function deleteKnowledgeDocument(string $id): void
    {
        $this->send($this->request('DELETE', '/api/v1/knowledge-documents/' . rawurlencode($id)));
    }

    /**
     * @param array<string, string> $files filename => raw file contents
     * @return list<KnowledgeDocumentResponse>
     * @throws PromptJugglerException
     */
    public function uploadDocuments(string $slug, array $files): array
    {
        // Random, so no file's contents can contain it.
        $boundary = bin2hex(random_bytes(20));
        $parts = array_map(
            // The server takes each document's name from its part's filename.
            static fn (int $index, string $filename, string $contents): string => "--{$boundary}\r\n"
                . "Content-Disposition: form-data; name=\"files[{$index}]\"; filename=\"{$filename}\"\r\n"
                . "Content-Type: application/octet-stream\r\n\r\n{$contents}\r\n",
            array_keys(array_values($files)),
            // PHP turns numeric-string keys into ints.
            array_map(
                static fn (int|string $filename): string => self::quotable((string) $filename),
                array_keys($files),
            ),
            array_values($files),
        );
        $request = $this->request('POST', '/api/v1/knowledge-bases/' . rawurlencode($slug) . '/documents')
            ->withHeader('Content-Type', "multipart/form-data; boundary={$boundary}")
            ->withBody($this->http->createStream(implode('', $parts) . "--{$boundary}--\r\n"))
        ;

        try {
            return $this->mapper->map(
                'list<' . KnowledgeDocumentResponse::class . '>',
                self::json($this->send($request)),
            );
        } catch (MappingError $e) {
            throw self::unexpectedShape($e);
        }
    }

    private function request(string $method, string $path): RequestInterface
    {
        return $this->http->createRequest($method, $this->baseUrl . $path)
            ->withHeader('Authorization', "Bearer {$this->apiKey}")
            ->withHeader('Accept', 'application/json')
        ;
    }

    /**
     * @param array<string, mixed> $body
     */
    private function withJson(RequestInterface $request, array $body): RequestInterface
    {
        try {
            $json = json_encode($body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } catch (JsonException $e) {
            throw new InvalidArgumentException("Cannot encode the request as JSON: {$e->getMessage()}", 0, $e);
        }

        return $request->withHeader('Content-Type', 'application/json')->withBody($this->http->createStream($json));
    }

    /**
     * @return string The response body.
     * @throws ApiException|NetworkException
     */
    private function send(RequestInterface $request): string
    {
        try {
            $response = $this->http->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new NetworkException($e->getMessage(), $e);
        }
        $body = self::body($response);

        $status = $response->getStatusCode();
        if ($status < 200 || $status >= 300) {
            throw new ApiException(
                self::serverError($body) ?? trim("{$status} {$response->getReasonPhrase()}"),
                $status,
            );
        }

        return $body;
    }

    /**
     * @template T of object
     * @param class-string<T> $class
     * @return T
     * @throws DecodeException
     */
    private function decode(string $class, string $body): object
    {
        try {
            return $this->mapper->map($class, self::json($body));
        } catch (MappingError $e) {
            throw self::unexpectedShape($e);
        }
    }

    /**
     * Request fields shared by prompt and workflow runs. Maps go out as objects, so an empty or
     * numeric-keyed one isn't encoded as a JSON list.
     *
     * @param array<string, string> $inputs
     * @param array<string, string>|null $envVars
     * @param array<string, string|list<string>>|null $metadata
     * @return array<string, mixed>
     */
    private static function runFields(
        array $inputs,
        ?Priority $priority,
        ?string $thread,
        ?string $environment,
        ?array $envVars,
        ?array $metadata,
    ): array {
        return [
            'inputs' => (object) $inputs,
            'priority' => $priority?->value,
            'thread' => $thread,
            'environment' => $environment,
            'envVars' => $envVars === null ? null : (object) $envVars,
            'metadata' => $metadata === null ? null : (object) $metadata,
        ];
    }

    /**
     * Escapes a filename for a quoted multipart header parameter. PHP's multipart parser
     * unescapes `\"`; a line break can't be represented at all.
     */
    private static function quotable(string $filename): string
    {
        if (strpbrk($filename, "\r\n")) {
            throw new InvalidArgumentException("A filename can't contain a line break: \"{$filename}\".");
        }

        return addcslashes($filename, '"\\');
    }

    /**
     * Drops the arguments the caller left out, so the server applies its own defaults.
     *
     * @param array<string, mixed> $fields
     * @return array<string, mixed>
     */
    private static function withoutNulls(array $fields): array
    {
        return array_filter($fields, static fn (mixed $value): bool => $value !== null);
    }

    /**
     * Reads the body, which a streaming client may still be receiving.
     *
     * @throws NetworkException
     */
    private static function body(ResponseInterface $response): string
    {
        $stream = $response->getBody();

        try {
            // A logging middleware can leave the body read to its end.
            if ($stream->isSeekable()) {
                $stream->rewind();
            }

            return $stream->getContents();
        } catch (RuntimeException $e) {
            throw new NetworkException($e->getMessage(), $e);
        }
    }

    /**
     * @throws DecodeException
     */
    private static function json(string $body): mixed
    {
        try {
            return json_decode($body, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new DecodeException("The API returned invalid JSON: {$e->getMessage()}", $e);
        }
    }

    private static function unexpectedShape(MappingError $e): DecodeException
    {
        return new DecodeException('The API returned an unexpected response: ' . implode('; ', array_map(
            static fn (NodeMessage $message): string => "{$message->path()}: {$message->toString()}",
            $e->messages()->toArray(),
        )), $e);
    }

    /**
     * The non-empty `error` field of a JSON error body.
     */
    private static function serverError(string $body): ?string
    {
        $json = json_decode($body, true);
        $error = \is_array($json) ? $json['error'] ?? null : null;

        return \is_string($error) && $error ? $error : null;
    }
}
