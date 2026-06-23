<?php

namespace PromptJuggler\Client\Api\V1\Prompts;

use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use PromptJuggler\Client\Api\V1\Prompts\Item\WithSlugItemRequestBuilder;

/**
 * Builds and executes requests for operations under /api/v1/prompts
*/
class PromptsRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the PromptJuggler/Client.api.v1.prompts.item collection
     * @param string $slug Prompt Handle
     * @return WithSlugItemRequestBuilder
    */
    public function bySlug(string $slug): WithSlugItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['slug'] = $slug;
        return new WithSlugItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new PromptsRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/prompts');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
