<?php

declare(strict_types=1);

namespace PromptJuggler\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\MultipartStream;
use Microsoft\Kiota\Abstractions\ApiException as KiotaApiException;
use Microsoft\Kiota\Abstractions\Authentication\BaseBearerTokenAuthenticationProvider;
use Microsoft\Kiota\Abstractions\MultiPartBody;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Http\GuzzleRequestAdapter;
use PromptJuggler\Client\Auth\StaticAccessTokenProvider;
use PromptJuggler\Client\Exception\ApiException;
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
use PromptJuggler\Client\Models\WorkflowRun;

/**
 * Synchronous, ergonomic entry point to the PromptJuggler API. Wraps the generated
 * Kiota client: flat methods in, generated typed models out.
 */
final class PromptJuggler
{
    private readonly RequestAdapter $adapter;
    private readonly PromptJugglerClient $client;

    public function __construct(string $apiKey, ?ClientInterface $httpClient = null)
    {
        $authProvider = new BaseBearerTokenAuthenticationProvider(new StaticAccessTokenProvider($apiKey));
        $this->adapter = new GuzzleRequestAdapter($authProvider, null, null, $httpClient);
        $this->client = new PromptJugglerClient($this->adapter);
    }

    public function getPrompt(string $slug, int|string $version): PromptRevision
    {
        return $this->send(
            fn () => $this->client->api()->v1()->prompts()->bySlug($slug)->byVersion((string) $version)->get()->wait(),
        );
    }

    /**
     * @param array<string, string>               $inputs
     * @param array<string, string>|null          $envVars
     * @param array<string, string|string[]>|null $metadata
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

    public function getPromptRun(string $id): PromptRun
    {
        return $this->send(fn () => $this->client->api()->v1()->promptruns()->byId($id)->get()->wait());
    }

    /**
     * @param array<string, string>               $inputs
     * @param array<string, string>|null          $envVars
     * @param array<string, string|string[]>|null $metadata
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

    public function getWorkflowRun(string $id): WorkflowRun
    {
        return $this->send(fn () => $this->client->api()->v1()->workflowruns()->byId($id)->get()->wait());
    }

    public function getKnowledgeBase(string $slug): KnowledgeBaseResponse
    {
        return $this->send(fn () => $this->client->api()->v1()->knowledgeBases()->bySlug($slug)->get()->wait());
    }

    public function getKnowledgeDocument(string $id): KnowledgeDocumentResponse
    {
        return $this->send(fn () => $this->client->api()->v1()->knowledgeDocuments()->byId($id)->get()->wait());
    }

    public function deleteKnowledgeDocument(string $id): void
    {
        $this->sendVoid(fn () => $this->client->api()->v1()->knowledgeDocuments()->byId($id)->delete()->wait());
    }

    /**
     * @param array<string, string> $files filename => raw file contents
     *
     * @return list<KnowledgeDocumentResponse>
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
     * Run a request that returns a value, translating Kiota's exception into the
     * SDK's own and guaranteeing a non-null result for the caller.
     *
     * @template T
     *
     * @param callable(): (T|null) $request
     *
     * @return T
     */
    private function send(callable $request): mixed
    {
        try {
            $result = $request();
        } catch (KiotaApiException $e) {
            throw $this->translate($e);
        }

        if ($result === null) {
            throw new ApiException('The API returned an empty response.', null);
        }

        return $result;
    }

    /**
     * Run a request with no response body (e.g. DELETE), translating errors.
     *
     * @param callable(): mixed $request
     */
    private function sendVoid(callable $request): void
    {
        try {
            $request();
        } catch (KiotaApiException $e) {
            throw $this->translate($e);
        }
    }

    private function translate(KiotaApiException $e): ApiException
    {
        $message = $e instanceof ErrorResponse && $e->getError() !== null
            ? $e->getError()
            : $e->getMessage();

        return new ApiException($message, $e->getResponseStatusCode(), $e);
    }
}
