<?php

namespace PromptJuggler\Client\Api\V1\Prompts\Item\Item\Runs;

use Exception;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use PromptJuggler\Client\Models\CreatePromptRun;
use PromptJuggler\Client\Models\CreatePromptRunResponse;
use PromptJuggler\Client\Models\ErrorResponse;

/**
 * Builds and executes requests for operations under /api/v1/prompts/{slug}/{version}/runs
*/
class RunsRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new RunsRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/prompts/{slug}/{version}/runs');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Triggers an asynchronous prompt run with the given inputs and returns a run ID and thread ID. Reference the prompt by version number, tag, or `__latest__`. Pass a thread ID to continue an existing conversation.
     * @param CreatePromptRun $body Request payload for creating a prompt run.
     * @param RunsRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<CreatePromptRunResponse|null>
     * @throws Exception
    */
    public function post(CreatePromptRun $body, ?RunsRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '403' => [ErrorResponse::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [CreatePromptRunResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * Triggers an asynchronous prompt run with the given inputs and returns a run ID and thread ID. Reference the prompt by version number, tag, or `__latest__`. Pass a thread ID to continue an existing conversation.
     * @param CreatePromptRun $body Request payload for creating a prompt run.
     * @param RunsRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(CreatePromptRun $body, ?RunsRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::POST;
        if ($requestConfiguration !== null) {
            $requestInfo->addHeaders($requestConfiguration->headers);
            $requestInfo->addRequestOptions(...$requestConfiguration->options);
        }
        $requestInfo->tryAddHeader('Accept', "application/json");
        $requestInfo->setContentFromParsable($this->requestAdapter, "application/json", $body);
        return $requestInfo;
    }

    /**
     * Returns a request builder with the provided arbitrary URL. Using this method means any other path or query parameters are ignored.
     * @param string $rawUrl The raw URL to use for the request builder.
     * @return RunsRequestBuilder
    */
    public function withUrl(string $rawUrl): RunsRequestBuilder {
        return new RunsRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
