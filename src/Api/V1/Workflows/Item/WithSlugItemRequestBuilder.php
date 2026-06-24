<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Api\V1\Workflows\Item;

use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use PromptJuggler\Client\Api\V1\Workflows\Item\Item\WithVersionItemRequestBuilder;

/**
 * Builds and executes requests for operations under /api/v1/workflows/{slug}
 */
class WithSlugItemRequestBuilder extends BaseRequestBuilder
{
    /**
     * Instantiates a new WithSlugItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
     */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter)
    {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/workflows/{slug}');
        if (\is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Gets an item from the PromptJuggler/Client.api.v1.workflows.item.item collection
     * @param string $version Specific version or tag or id
     */
    public function byVersion(string $version): WithVersionItemRequestBuilder
    {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['version'] = $version;

        return new WithVersionItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }
}
