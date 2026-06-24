<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Api\V1;

use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use PromptJuggler\Client\Api\V1\KnowledgeBases\KnowledgeBasesRequestBuilder;
use PromptJuggler\Client\Api\V1\KnowledgeDocuments\KnowledgeDocumentsRequestBuilder;
use PromptJuggler\Client\Api\V1\Promptruns\PromptrunsRequestBuilder;
use PromptJuggler\Client\Api\V1\Prompts\PromptsRequestBuilder;
use PromptJuggler\Client\Api\V1\Workflowruns\WorkflowrunsRequestBuilder;
use PromptJuggler\Client\Api\V1\Workflows\WorkflowsRequestBuilder;

/**
 * Builds and executes requests for operations under /api/v1
 */
class V1RequestBuilder extends BaseRequestBuilder
{
    /**
     * Instantiates a new V1RequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
     */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter)
    {
        parent::__construct($requestAdapter, [], '{+baseurl}/api/v1');
        if (\is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * The knowledgeBases property
     */
    public function knowledgeBases(): KnowledgeBasesRequestBuilder
    {
        return new KnowledgeBasesRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The knowledgeDocuments property
     */
    public function knowledgeDocuments(): KnowledgeDocumentsRequestBuilder
    {
        return new KnowledgeDocumentsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The promptruns property
     */
    public function promptruns(): PromptrunsRequestBuilder
    {
        return new PromptrunsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The prompts property
     */
    public function prompts(): PromptsRequestBuilder
    {
        return new PromptsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The workflowruns property
     */
    public function workflowruns(): WorkflowrunsRequestBuilder
    {
        return new WorkflowrunsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The workflows property
     */
    public function workflows(): WorkflowsRequestBuilder
    {
        return new WorkflowsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
}
