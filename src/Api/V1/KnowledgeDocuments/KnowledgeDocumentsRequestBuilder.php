<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Api\V1\KnowledgeDocuments;

use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use PromptJuggler\Client\Api\V1\KnowledgeDocuments\Item\KnowledgeDocumentsItemRequestBuilder;

/**
 * Builds and executes requests for operations under /api/v1/knowledge-documents
 */
class KnowledgeDocumentsRequestBuilder extends BaseRequestBuilder
{
    /**
     * Instantiates a new KnowledgeDocumentsRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
     */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter)
    {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1/knowledge-documents');
        if (\is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Gets an item from the PromptJuggler/Client.api.v1.knowledgeDocuments.item collection
     * @param string $id Document ID
     */
    public function byId(string $id): KnowledgeDocumentsItemRequestBuilder
    {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['id'] = $id;

        return new KnowledgeDocumentsItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }
}
