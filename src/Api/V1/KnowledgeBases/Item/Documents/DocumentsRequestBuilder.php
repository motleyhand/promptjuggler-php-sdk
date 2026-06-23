<?php

namespace PromptJuggler\Client\Api\V1\KnowledgeBases\Item\Documents;

use Exception;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\MultiPartBody;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use PromptJuggler\Client\Models\ErrorResponse;
use PromptJuggler\Client\Models\KnowledgeDocumentResponse;

/**
 * Builds and executes requests for operations under /api/v1/knowledge-bases/{slug}/documents
*/
class DocumentsRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new DocumentsRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/knowledge-bases/{slug}/documents');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Uploads one or more files to a knowledge base for chunking and embedding. Documents are processed asynchronously. Listen for the knowledgedocument.finished webhook or poll the document endpoint to know when they are searchable.
     * @param MultiPartBody $body The request body
     * @param DocumentsRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<array<KnowledgeDocumentResponse>|null>
     * @throws Exception
    */
    public function post(MultiPartBody $body, ?DocumentsRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '403' => [ErrorResponse::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendCollectionAsync($requestInfo, [KnowledgeDocumentResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * Uploads one or more files to a knowledge base for chunking and embedding. Documents are processed asynchronously. Listen for the knowledgedocument.finished webhook or poll the document endpoint to know when they are searchable.
     * @param MultiPartBody $body The request body
     * @param DocumentsRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(MultiPartBody $body, ?DocumentsRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::POST;
        if ($requestConfiguration !== null) {
            $requestInfo->addHeaders($requestConfiguration->headers);
            $requestInfo->addRequestOptions(...$requestConfiguration->options);
        }
        $requestInfo->tryAddHeader('Accept', "application/json");
        $requestInfo->setContentFromParsable($this->requestAdapter, "multipart/form-data", $body);
        return $requestInfo;
    }

    /**
     * Returns a request builder with the provided arbitrary URL. Using this method means any other path or query parameters are ignored.
     * @param string $rawUrl The raw URL to use for the request builder.
     * @return DocumentsRequestBuilder
    */
    public function withUrl(string $rawUrl): DocumentsRequestBuilder {
        return new DocumentsRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
