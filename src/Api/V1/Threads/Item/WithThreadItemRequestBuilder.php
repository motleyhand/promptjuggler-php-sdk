<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Api\V1\Threads\Item;

use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use PromptJuggler\Client\Api\V1\Threads\Item\StreamToken\StreamTokenRequestBuilder;

/**
 * Builds and executes requests for operations under /api/v1/threads/{thread}
 */
class WithThreadItemRequestBuilder extends BaseRequestBuilder
{
    /**
     * Instantiates a new WithThreadItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
     */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter)
    {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/threads/{thread}');
        if (\is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * The streamToken property
     */
    public function streamToken(): StreamTokenRequestBuilder
    {
        return new StreamTokenRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
}
