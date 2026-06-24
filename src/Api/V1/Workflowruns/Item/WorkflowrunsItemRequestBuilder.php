<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Api\V1\Workflowruns\Item;

use Exception;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use PromptJuggler\Client\Models\ErrorResponse;
use PromptJuggler\Client\Models\WorkflowRun;

/**
 * Builds and executes requests for operations under /api/v1/workflowruns/{id}
 */
class WorkflowrunsItemRequestBuilder extends BaseRequestBuilder
{
    /**
     * Instantiates a new WorkflowrunsItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
     */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter)
    {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/workflowruns/{id}');
        if (\is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Retrieves the current state of a workflow run, including status, outputs, and errors. Poll this endpoint after receiving a webhook notification, or use it to check the status of a run in progress.
     * @param WorkflowrunsItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<WorkflowRun|null>
     * @throws Exception
     */
    public function get(?WorkflowrunsItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise
    {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
            '403' => [ErrorResponse::class, 'createFromDiscriminatorValue'],
        ];

        return $this->requestAdapter->sendAsync(
            $requestInfo,
            [WorkflowRun::class, 'createFromDiscriminatorValue'],
            $errorMappings,
        );
    }

    /**
     * Retrieves the current state of a workflow run, including status, outputs, and errors. Poll this endpoint after receiving a webhook notification, or use it to check the status of a run in progress.
     * @param WorkflowrunsItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     */
    public function toGetRequestInformation(
        ?WorkflowrunsItemRequestBuilderGetRequestConfiguration $requestConfiguration = null,
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
    public function withUrl(string $rawUrl): WorkflowrunsItemRequestBuilder
    {
        return new WorkflowrunsItemRequestBuilder($rawUrl, $this->requestAdapter);
    }
}
