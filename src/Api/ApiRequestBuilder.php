<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Api;

use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use PromptJuggler\Client\Api\V1\V1RequestBuilder;

/**
 * Builds and executes requests for operations under /api
 */
class ApiRequestBuilder extends BaseRequestBuilder
{
    /**
     * Instantiates a new ApiRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
     */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter)
    {
        parent::__construct($requestAdapter, [], '{+baseurl}/api');
        if (\is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * The v1 property
     */
    public function v1(): V1RequestBuilder
    {
        return new V1RequestBuilder($this->pathParameters, $this->requestAdapter);
    }
}
