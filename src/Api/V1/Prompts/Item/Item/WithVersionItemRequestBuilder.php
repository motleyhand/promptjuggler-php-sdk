<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Api\V1\Prompts\Item\Item;

use Exception;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use PromptJuggler\Client\Api\V1\Prompts\Item\Item\Runs\RunsRequestBuilder;
use PromptJuggler\Client\Models\PromptRevision;

/**
 * Builds and executes requests for operations under /api/v1/prompts/{slug}/{version}
 */
class WithVersionItemRequestBuilder extends BaseRequestBuilder
{
    /**
     * Instantiates a new WithVersionItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
     */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter)
    {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/prompts/{slug}/{version}');
        if (\is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * The runs property
     */
    public function runs(): RunsRequestBuilder
    {
        return new RunsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }

    /**
     * Retrieves the full configuration of a prompt revision including model, parameters, tool calls, messages.
     * @param WithVersionItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<PromptRevision|null>
     * @throws Exception
     */
    public function get(?WithVersionItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise
    {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);

        return $this->requestAdapter->sendAsync(
            $requestInfo,
            [PromptRevision::class, 'createFromDiscriminatorValue'],
            null,
        );
    }

    /**
     * Retrieves the full configuration of a prompt revision including model, parameters, tool calls, messages.
     * @param WithVersionItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     */
    public function toGetRequestInformation(
        ?WithVersionItemRequestBuilderGetRequestConfiguration $requestConfiguration = null,
    ): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::GET;
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
    public function withUrl(string $rawUrl): WithVersionItemRequestBuilder
    {
        return new WithVersionItemRequestBuilder($rawUrl, $this->requestAdapter);
    }
}
