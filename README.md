# OpenAPIClient-php

PromptJuggler API


## Installation & Usage

### Requirements

PHP 8.1 and later.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/GIT_USER_ID/GIT_REPO_ID.git"
    }
  ],
  "require": {
    "GIT_USER_ID/GIT_REPO_ID": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/OpenAPIClient-php/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure Bearer authorization: Bearer
$config = PromptJuggler\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new PromptJuggler\Client\Api\KnowledgeBasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$id = 'id_example'; // string | Document ID

try {
    $apiInstance->publicDeleteDocument($id);
} catch (Exception $e) {
    echo 'Exception when calling KnowledgeBasesApi->publicDeleteDocument: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *https://promptjuggler.com/api/v1*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*KnowledgeBasesApi* | [**publicDeleteDocument**](docs/Api/KnowledgeBasesApi.md#publicdeletedocument) | **DELETE** /api/v1/knowledge-documents/{id} | Delete a knowledge document
*KnowledgeBasesApi* | [**publicGetDocument**](docs/Api/KnowledgeBasesApi.md#publicgetdocument) | **GET** /api/v1/knowledge-documents/{id} | Get a knowledge document by ID
*KnowledgeBasesApi* | [**publicGetKnowledgeBase**](docs/Api/KnowledgeBasesApi.md#publicgetknowledgebase) | **GET** /api/v1/knowledge-bases/{slug} | Get a knowledge base by slug
*KnowledgeBasesApi* | [**publicUploadDocuments**](docs/Api/KnowledgeBasesApi.md#publicuploaddocuments) | **POST** /api/v1/knowledge-bases/{slug}/documents | Upload documents to a knowledge base
*PromptRunsApi* | [**createPromptRun**](docs/Api/PromptRunsApi.md#createpromptrun) | **POST** /api/v1/prompts/{slug}/{version}/runs | Create and trigger a prompt run
*PromptRunsApi* | [**getPromptRun**](docs/Api/PromptRunsApi.md#getpromptrun) | **GET** /api/v1/promptruns/{id} | Get a prompt run by ID
*PromptsApi* | [**getPromptRevision**](docs/Api/PromptsApi.md#getpromptrevision) | **GET** /api/v1/prompts/{slug}/{version} | Get a prompt revision by the prompt’s slug and version
*WorkflowRunsApi* | [**createWorkflowRun**](docs/Api/WorkflowRunsApi.md#createworkflowrun) | **POST** /api/v1/workflows/{slug}/{version}/runs | Create and trigger a workflow run
*WorkflowRunsApi* | [**getWorkflowRun**](docs/Api/WorkflowRunsApi.md#getworkflowrun) | **GET** /api/v1/workflowruns/{id} | Get a workflow run by ID

## Models

- [ContentMessageResponse](docs/Model/ContentMessageResponse.md)
- [CreatePromptRun](docs/Model/CreatePromptRun.md)
- [CreatePromptRunResponse](docs/Model/CreatePromptRunResponse.md)
- [CreateWorkflowRun](docs/Model/CreateWorkflowRun.md)
- [CreateWorkflowRunMetadataValue](docs/Model/CreateWorkflowRunMetadataValue.md)
- [CreateWorkflowRunMetadataValueOneOf](docs/Model/CreateWorkflowRunMetadataValueOneOf.md)
- [CreateWorkflowRunResponse](docs/Model/CreateWorkflowRunResponse.md)
- [ErrorResponse](docs/Model/ErrorResponse.md)
- [GetPromptRevisionVersionParameter](docs/Model/GetPromptRevisionVersionParameter.md)
- [HttpCall](docs/Model/HttpCall.md)
- [HttpHeader](docs/Model/HttpHeader.md)
- [JsonObjectFormat](docs/Model/JsonObjectFormat.md)
- [JsonSchemaFormat](docs/Model/JsonSchemaFormat.md)
- [KnowledgeBaseFinished](docs/Model/KnowledgeBaseFinished.md)
- [KnowledgeBaseResponse](docs/Model/KnowledgeBaseResponse.md)
- [KnowledgeBaseStatus](docs/Model/KnowledgeBaseStatus.md)
- [KnowledgeDocumentFinished](docs/Model/KnowledgeDocumentFinished.md)
- [KnowledgeDocumentResponse](docs/Model/KnowledgeDocumentResponse.md)
- [KnowledgeDocumentStatus](docs/Model/KnowledgeDocumentStatus.md)
- [KnowledgeDocumentSummary](docs/Model/KnowledgeDocumentSummary.md)
- [KnowledgeSearch](docs/Model/KnowledgeSearch.md)
- [Mcp](docs/Model/Mcp.md)
- [Memory](docs/Model/Memory.md)
- [Model](docs/Model/Model.md)
- [ModelParams](docs/Model/ModelParams.md)
- [PromptCall](docs/Model/PromptCall.md)
- [PromptRevision](docs/Model/PromptRevision.md)
- [PromptRun](docs/Model/PromptRun.md)
- [PromptRunFinished](docs/Model/PromptRunFinished.md)
- [Provider](docs/Model/Provider.md)
- [ResponseFormat](docs/Model/ResponseFormat.md)
- [Role](docs/Model/Role.md)
- [RunStatus](docs/Model/RunStatus.md)
- [ScriptCall](docs/Model/ScriptCall.md)
- [ServiceTier](docs/Model/ServiceTier.md)
- [TextFormat](docs/Model/TextFormat.md)
- [Tool](docs/Model/Tool.md)
- [VersionRef](docs/Model/VersionRef.md)
- [VersionRefIdOrTag](docs/Model/VersionRefIdOrTag.md)
- [WebSearch](docs/Model/WebSearch.md)
- [WorkflowCall](docs/Model/WorkflowCall.md)
- [WorkflowRun](docs/Model/WorkflowRun.md)
- [WorkflowRunFinished](docs/Model/WorkflowRunFinished.md)

## Authorization

### Bearer

- **Type**: Bearer authentication


### WebhookSignature

- **Type**: API key
- **API key parameter name**: PromptJuggler-Signature
- **Location**: HTTP header


## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `1.0.0`
    - Generator version: `7.23.0`
- Build package: `org.openapitools.codegen.languages.PhpNextgenClientCodegen`
