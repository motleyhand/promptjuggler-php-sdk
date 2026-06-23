<?php

namespace PromptJuggler\Client\Api\V1\KnowledgeBases\Item;

use Exception;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use PromptJuggler\Client\Api\V1\KnowledgeBases\Item\Documents\DocumentsRequestBuilder;
use PromptJuggler\Client\Models\ErrorResponse;
use PromptJuggler\Client\Models\KnowledgeBaseResponse;

/**
 * Builds and executes requests for operations under /api/v1/knowledge-bases/{slug}
*/
class WithSlugItemRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The documents property
    */
    public function documents(): DocumentsRequestBuilder {
        return new DocumentsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new WithSlugItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/knowledge-bases/{slug}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Retrieves a knowledge base with its processing status, document count, chunk count, and a list of all documents. Use this to verify that uploaded documents have finished indexing before relying on them in prompts.
     * @param WithSlugItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<KnowledgeBaseResponse|null>
     * @throws Exception
    */
    public function get(?WithSlugItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '403' => [ErrorResponse::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [KnowledgeBaseResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * Retrieves a knowledge base with its processing status, document count, chunk count, and a list of all documents. Use this to verify that uploaded documents have finished indexing before relying on them in prompts.
     * @param WithSlugItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?WithSlugItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::GET;
        if ($requestConfiguration !== null) {
            $requestInfo->addHeaders($requestConfiguration->headers);
            $requestInfo->addRequestOptions(...$requestConfiguration->options);
        }
        $requestInfo->tryAddHeader('Accept', "application/json");
        return $requestInfo;
    }

    /**
     * Returns a request builder with the provided arbitrary URL. Using this method means any other path or query parameters are ignored.
     * @param string $rawUrl The raw URL to use for the request builder.
     * @return WithSlugItemRequestBuilder
    */
    public function withUrl(string $rawUrl): WithSlugItemRequestBuilder {
        return new WithSlugItemRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
