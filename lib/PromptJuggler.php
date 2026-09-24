<?php

declare(strict_types=1);

namespace PromptJuggler\Client;

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\MultipartStream;
use LogicException;
use Microsoft\Kiota\Abstractions\ApiException as KiotaApiException;
use Microsoft\Kiota\Abstractions\Authentication\BaseBearerTokenAuthenticationProvider;
use Microsoft\Kiota\Abstractions\MultiPartBody;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Http\GuzzleRequestAdapter;
use Microsoft\Kiota\Http\KiotaClientFactory;
use PromptJuggler\Client\Auth\StaticAccessTokenProvider;
use PromptJuggler\Client\Exception\ApiException;
use PromptJuggler\Client\Exception\DecodeException;
use PromptJuggler\Client\Exception\NetworkException;
use PromptJuggler\Client\Exception\PromptJugglerException;
use PromptJuggler\Client\Http\ResponseRecordingClient;
use PromptJuggler\Client\Models\CreatePromptRun;
use PromptJuggler\Client\Models\CreatePromptRun_envVars;
use PromptJuggler\Client\Models\CreatePromptRun_inputs;
use PromptJuggler\Client\Models\CreatePromptRun_metadata;
use PromptJuggler\Client\Models\CreatePromptRun_priority;
use PromptJuggler\Client\Models\CreatePromptRunResponse;
use PromptJuggler\Client\Models\CreateWorkflowRun;
use PromptJuggler\Client\Models\CreateWorkflowRun_envVars;
use PromptJuggler\Client\Models\CreateWorkflowRun_inputs;
use PromptJuggler\Client\Models\CreateWorkflowRun_metadata;
use PromptJuggler\Client\Models\CreateWorkflowRun_priority;
use PromptJuggler\Client\Models\CreateWorkflowRunResponse;
use PromptJuggler\Client\Models\ErrorResponse;
use PromptJuggler\Client\Models\KnowledgeBaseResponse;
use PromptJuggler\Client\Models\KnowledgeDocumentResponse;
use PromptJuggler\Client\Models\PromptRevision;
use PromptJuggler\Client\Models\PromptRun;
use PromptJuggler\Client\Models\StreamTokenResponse;
use PromptJuggler\Client\Models\WorkflowRun;
use TypeError;

/**
 * Synchronous, ergonomic entry point to the PromptJuggler API. Wraps the generated
 * Kiota client: flat methods in, generated typed models out.
 */
final class PromptJuggler
{
    private readonly ResponseRecordingClient $http;
    private readonly RequestAdapter $adapter;
    private readonly PromptJugglerClient $client;

    public function __construct(string $apiKey, ?ClientInterface $httpClient = null)
    {
        $authProvider = new BaseBearerTokenAuthenticationProvider(new StaticAccessTokenProvider($apiKey));
        $this->http = new ResponseRecordingClient($httpClient ?? KiotaClientFactory::create());
        $this->adapter = new GuzzleRequestAdapter($authProvider, null, null, $this->http);
        $this->client = new PromptJugglerClient($this->adapter);
    }

    /**
     * @throws PromptJugglerException
     */
    public function getPrompt(string $slug, int|string $version): PromptRevision
    {
        return $this->send(
            fn () => $this->client->api()->v1()->prompts()->bySlug($slug)->byVersion((string) $version)->get()->wait(),
        );
    }

    /**
     * @param array<string, string> $inputs
     * @param array<string, string>|null $envVars
     * @param array<string, string|string[]>|null $metadata
     * @throws PromptJugglerException
     */
    public function runPrompt(
        string $slug,
        int|string $version,
        array $inputs,
        ?string $priority = null,
        ?string $thread = null,
        ?string $environment = null,
        ?array $envVars = null,
        ?array $metadata = null,
        ?string $channel = null,
    ): CreatePromptRunResponse {
        $body = new CreatePromptRun();

        $inputsModel = new CreatePromptRun_inputs();
        $inputsModel->setAdditionalData($inputs);
        $body->setInputs($inputsModel);

        if ($priority !== null) {
            $body->setPriority(new CreatePromptRun_priority($priority));
        }
        if ($thread !== null) {
            $body->setThread($thread);
        }
        if ($environment !== null) {
            $body->setEnvironment($environment);
        }
        if ($envVars !== null) {
            $envVarsModel = new CreatePromptRun_envVars();
            $envVarsModel->setAdditionalData($envVars);
            $body->setEnvVars($envVarsModel);
        }
        if ($metadata !== null) {
            $metadataModel = new CreatePromptRun_metadata();
            $metadataModel->setAdditionalData($metadata);
            $body->setMetadata($metadataModel);
        }
        if ($channel !== null) {
            $body->setChannel($channel);
        }

        return $this->send(
            fn () => $this->client->api()->v1()->prompts()->bySlug($slug)->byVersion((string) $version)->runs()->post(
                $body,
            )->wait(),
        );
    }

    /**
     * @throws PromptJugglerException
     */
    public function getPromptRun(string $id): PromptRun
    {
        return $this->send(fn () => $this->client->api()->v1()->promptruns()->byId($id)->get()->wait());
    }

    /**
     * @param array<string, string> $inputs
     * @param array<string, string>|null $envVars
     * @param array<string, string|string[]>|null $metadata
     * @throws PromptJugglerException
     */
    public function runWorkflow(
        string $slug,
        int|string $version,
        array $inputs,
        ?string $priority = null,
        ?string $thread = null,
        ?string $environment = null,
        ?array $envVars = null,
        ?array $metadata = null,
    ): CreateWorkflowRunResponse {
        $body = new CreateWorkflowRun();

        $inputsModel = new CreateWorkflowRun_inputs();
        $inputsModel->setAdditionalData($inputs);
        $body->setInputs($inputsModel);

        if ($priority !== null) {
            $body->setPriority(new CreateWorkflowRun_priority($priority));
        }
        if ($thread !== null) {
            $body->setThread($thread);
        }
        if ($environment !== null) {
            $body->setEnvironment($environment);
        }
        if ($envVars !== null) {
            $envVarsModel = new CreateWorkflowRun_envVars();
            $envVarsModel->setAdditionalData($envVars);
            $body->setEnvVars($envVarsModel);
        }
        if ($metadata !== null) {
            $metadataModel = new CreateWorkflowRun_metadata();
            $metadataModel->setAdditionalData($metadata);
            $body->setMetadata($metadataModel);
        }

        return $this->send(
            fn () => $this->client->api()->v1()->workflows()->bySlug($slug)->byVersion((string) $version)->runs()->post(
                $body,
            )->wait(),
        );
    }

    /**
     * @throws PromptJugglerException
     */
    public function getWorkflowRun(string $id): WorkflowRun
    {
        return $this->send(fn () => $this->client->api()->v1()->workflowruns()->byId($id)->get()->wait());
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
        return $this->send(
            fn () => $this->client->api()->v1()->threads()->byThread($thread)->streamToken()->post()->wait(),
        );
    }

    /**
     * @throws PromptJugglerException
     */
    public function getKnowledgeBase(string $slug): KnowledgeBaseResponse
    {
        return $this->send(fn () => $this->client->api()->v1()->knowledgeBases()->bySlug($slug)->get()->wait());
    }

    /**
     * @throws PromptJugglerException
     */
    public function getKnowledgeDocument(string $id): KnowledgeDocumentResponse
    {
        return $this->send(fn () => $this->client->api()->v1()->knowledgeDocuments()->byId($id)->get()->wait());
    }

    /**
     * @throws PromptJugglerException
     */
    public function deleteKnowledgeDocument(string $id): void
    {
        $this->sendVoid(fn () => $this->client->api()->v1()->knowledgeDocuments()->byId($id)->delete()->wait());
    }

    /**
     * @param array<string, string> $files filename => raw file contents
     * @return list<KnowledgeDocumentResponse>
     * @throws PromptJugglerException
     */
    public function uploadDocuments(string $slug, array $files): array
    {
        $index = 0;
        $parts = [];
        foreach ($files as $filename => $contents) {
            $parts[] = ['name' => "files[{$index}]", 'filename' => $filename, 'contents' => $contents];
            ++$index;
        }
        $multipart = new MultipartStream($parts);

        // Kiota's MultiPartBody can't set per-part filenames, but this endpoint needs
        // them (the server reads getClientOriginalName). Build the multipart body with
        // Guzzle and inject it into the request the generated builder would have sent.
        $requestInfo = $this->client->api()->v1()->knowledgeBases()->bySlug($slug)->documents()
            // @phpstan-ignore missingType.checkedException (Kiota bug: MultiPartBody::__construct's @throws Exception is really RandomException from random_bytes)
            ->toPostRequestInformation(new MultiPartBody())
        ;
        $requestInfo->content = $multipart;
        $requestInfo->setHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'multipart/form-data; boundary=' . $multipart->getBoundary(),
        ]);

        return array_values($this->send(fn () => $this->adapter->sendCollectionAsync(
            $requestInfo,
            [KnowledgeDocumentResponse::class, 'createFromDiscriminatorValue'],
            ['4XX' => [ErrorResponse::class, 'createFromDiscriminatorValue'], '5XX' => [
                ErrorResponse::class,
                'createFromDiscriminatorValue',
            ]],
        )->wait()));
    }

    /**
     * Run a request that returns a value, guaranteeing a non-null result for the caller.
     *
     * @template T
     * @param callable(): (T|null) $request
     * @return T
     * @throws PromptJugglerException
     */
    private function send(callable $request): mixed
    {
        return $this->call($request) ?? throw new DecodeException('The API returned an empty response.');
    }

    /**
     * Run a request with no response body (e.g. DELETE).
     *
     * @param callable(): mixed $request
     * @throws PromptJugglerException
     */
    private function sendVoid(callable $request): void
    {
        $this->call($request);
    }

    /**
     * Run a request, translating what Kiota and Guzzle throw into the SDK's own exceptions.
     *
     * @template T
     * @param callable(): T $request
     * @return T
     * @throws ApiException|DecodeException|NetworkException
     */
    private function call(callable $request): mixed
    {
        $this->http->forget();

        try {
            return $request();
        } catch (KiotaApiException $e) {
            throw $this->translate($e);
        } catch (TransferException $e) {
            throw new NetworkException($e->getMessage(), $e);
        } catch (Exception|TypeError $e) {
            // Kiota throws plain exceptions (a TypeError for a mistyped enum) on a body it can't read,
            // whatever the status it came with.
            $response = $this->http->lastResponse() ?? throw new LogicException($e->getMessage(), 0, $e);
            $status = $response->getStatusCode();

            throw $status < 400
                ? new DecodeException($e->getMessage(), $e)
                : new ApiException(trim("{$status} {$response->getReasonPhrase()}"), $status, $e);
        }
    }

    private function translate(KiotaApiException $e): ApiException
    {
        return new ApiException($this->serverError() ?? $e->getMessage(), $e->getResponseStatusCode(), $e);
    }

    /**
     * The `error` field of the last response's JSON body, if it has one.
     */
    private function serverError(): ?string
    {
        $body = json_decode((string) $this->http->lastResponse()?->getBody(), true);

        return \is_array($body) && \is_string($body['error'] ?? null) ? $body['error'] : null;
    }
}
