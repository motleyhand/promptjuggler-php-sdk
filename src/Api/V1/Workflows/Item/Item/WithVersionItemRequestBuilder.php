<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Api\V1\Workflows\Item\Item;

use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use PromptJuggler\Client\Api\V1\Workflows\Item\Item\Runs\RunsRequestBuilder;

/**
 * Builds and executes requests for operations under /api/v1/workflows/{slug}/{version}
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
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/workflows/{slug}/{version}');
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
}
