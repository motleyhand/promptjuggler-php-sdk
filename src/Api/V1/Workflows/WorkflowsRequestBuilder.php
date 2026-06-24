<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Api\V1\Workflows;

use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use PromptJuggler\Client\Api\V1\Workflows\Item\WithSlugItemRequestBuilder;

/**
 * Builds and executes requests for operations under /api/v1/workflows
 */
class WorkflowsRequestBuilder extends BaseRequestBuilder
{
    /**
     * Instantiates a new WorkflowsRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
     */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter)
    {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/workflows');
        if (\is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Gets an item from the PromptJuggler/Client.api.v1.workflows.item collection
     * @param string $slug Workflow Handle
     */
    public function bySlug(string $slug): WithSlugItemRequestBuilder
    {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['slug'] = $slug;

        return new WithSlugItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }
}
