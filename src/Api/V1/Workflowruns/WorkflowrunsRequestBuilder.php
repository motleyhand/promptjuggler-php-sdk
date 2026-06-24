<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Api\V1\Workflowruns;

use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use PromptJuggler\Client\Api\V1\Workflowruns\Item\WorkflowrunsItemRequestBuilder;

/**
 * Builds and executes requests for operations under /api/v1/workflowruns
 */
class WorkflowrunsRequestBuilder extends BaseRequestBuilder
{
    /**
     * Instantiates a new WorkflowrunsRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
     */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter)
    {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/workflowruns');
        if (\is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Gets an item from the PromptJuggler/Client.api.v1.workflowruns.item collection
     * @param string $id Workflow run ID
     */
    public function byId(string $id): WorkflowrunsItemRequestBuilder
    {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['id'] = $id;

        return new WorkflowrunsItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }
}
