<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Api\V1\Threads\Item\StreamToken;

use Exception;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use PromptJuggler\Client\Models\ErrorResponse;
use PromptJuggler\Client\Models\StreamTokenResponse;

/**
 * Builds and executes requests for operations under /api/v1/threads/{thread}/stream-token
 */
class StreamTokenRequestBuilder extends BaseRequestBuilder
{
    /**
     * Instantiates a new StreamTokenRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
     */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter)
    {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/threads/{thread}/stream-token');
        if (\is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Returns a short-lived, thread-scoped token your frontend can use to subscribe to live token output over SSE. Call this from your backend with your API key, then hand the token to the browser — the API key itself must never leave your server. The thread does not have to exist yet: mint a token, connect, then start the run. Connect before triggering a run, since tokens emitted while nobody is subscribed are not replayed.
     * @param StreamTokenRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamTokenResponse|null>
     * @throws Exception
     */
    public function post(?StreamTokenRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise
    {
        $requestInfo = $this->toPostRequestInformation($requestConfiguration);
        $errorMappings = [
            '403' => [ErrorResponse::class, 'createFromDiscriminatorValue'],
        ];

        return $this->requestAdapter->sendAsync(
            $requestInfo,
            [StreamTokenResponse::class, 'createFromDiscriminatorValue'],
            $errorMappings,
        );
    }

    /**
     * Returns a short-lived, thread-scoped token your frontend can use to subscribe to live token output over SSE. Call this from your backend with your API key, then hand the token to the browser — the API key itself must never leave your server. The thread does not have to exist yet: mint a token, connect, then start the run. Connect before triggering a run, since tokens emitted while nobody is subscribed are not replayed.
     * @param StreamTokenRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     */
    public function toPostRequestInformation(
        ?StreamTokenRequestBuilderPostRequestConfiguration $requestConfiguration = null,
    ): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::POST;
        if ($requestConfiguration !== null) {
            $requestInfo->addHeaders($requestConfiguration->headers);
            $requestInfo->addRequestOptions(...$requestConfiguration->options);
        }
        $requestInfo->tryAddHeader('Accept', 'application/json');

        return $requestInfo;
    }

    /**
     * Returns a request builder with the provided arbitrary URL. Using this method means any other path or query parameters are ignored.
     * @param string $rawUrl The raw URL to use for the request builder.
     */
    public function withUrl(string $rawUrl): StreamTokenRequestBuilder
    {
        return new StreamTokenRequestBuilder($rawUrl, $this->requestAdapter);
    }
}
