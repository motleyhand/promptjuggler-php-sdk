# PromptJuggler\Client\KnowledgeBasesApi

All URIs are relative to https://promptjuggler.com/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**publicDeleteDocument()**](KnowledgeBasesApi.md#publicDeleteDocument) | **DELETE** /api/v1/knowledge-documents/{id} | Delete a knowledge document |
| [**publicGetDocument()**](KnowledgeBasesApi.md#publicGetDocument) | **GET** /api/v1/knowledge-documents/{id} | Get a knowledge document by ID |
| [**publicGetKnowledgeBase()**](KnowledgeBasesApi.md#publicGetKnowledgeBase) | **GET** /api/v1/knowledge-bases/{slug} | Get a knowledge base by slug |
| [**publicUploadDocuments()**](KnowledgeBasesApi.md#publicUploadDocuments) | **POST** /api/v1/knowledge-bases/{slug}/documents | Upload documents to a knowledge base |


## `publicDeleteDocument()`

```php
publicDeleteDocument($id)
```

Delete a knowledge document

Permanently removes a document and all its chunks from the knowledge base. Search results will no longer include content from this document.

### Example

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

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Document ID | |

### Return type

void (empty response body)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `publicGetDocument()`

```php
publicGetDocument($id): \PromptJuggler\Client\Model\KnowledgeDocumentResponse
```

Get a knowledge document by ID

Retrieves a single document with its processing status, file name, size, and chunk count. Use this to check whether a recently uploaded document has finished indexing.

### Example

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
    $result = $apiInstance->publicGetDocument($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KnowledgeBasesApi->publicGetDocument: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Document ID | |

### Return type

[**\PromptJuggler\Client\Model\KnowledgeDocumentResponse**](../Model/KnowledgeDocumentResponse.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `publicGetKnowledgeBase()`

```php
publicGetKnowledgeBase($slug): \PromptJuggler\Client\Model\KnowledgeBaseResponse
```

Get a knowledge base by slug

Retrieves a knowledge base with its processing status, document count, chunk count, and a list of all documents. Use this to verify that uploaded documents have finished indexing before relying on them in prompts.

### Example

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
$slug = 'slug_example'; // string | Knowledge base handle

try {
    $result = $apiInstance->publicGetKnowledgeBase($slug);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KnowledgeBasesApi->publicGetKnowledgeBase: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug** | **string**| Knowledge base handle | |

### Return type

[**\PromptJuggler\Client\Model\KnowledgeBaseResponse**](../Model/KnowledgeBaseResponse.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `publicUploadDocuments()`

```php
publicUploadDocuments($slug, $files): \PromptJuggler\Client\Model\KnowledgeDocumentResponse[]
```

Upload documents to a knowledge base

Uploads one or more files to a knowledge base for chunking and embedding. Documents are processed asynchronously. Listen for the knowledgedocument.finished webhook or poll the document endpoint to know when they are searchable.

### Example

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
$slug = 'slug_example'; // string | Knowledge base handle
$files = array('/path/to/file.txt'); // \SplFileObject[]

try {
    $result = $apiInstance->publicUploadDocuments($slug, $files);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KnowledgeBasesApi->publicUploadDocuments: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug** | **string**| Knowledge base handle | |
| **files** | **\SplFileObject[]**|  | [optional] |

### Return type

[**\PromptJuggler\Client\Model\KnowledgeDocumentResponse[]**](../Model/KnowledgeDocumentResponse.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
