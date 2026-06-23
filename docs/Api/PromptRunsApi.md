# PromptJuggler\Client\PromptRunsApi

All URIs are relative to https://promptjuggler.com/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createPromptRun()**](PromptRunsApi.md#createPromptRun) | **POST** /api/v1/prompts/{slug}/{version}/runs | Create and trigger a prompt run |
| [**getPromptRun()**](PromptRunsApi.md#getPromptRun) | **GET** /api/v1/promptruns/{id} | Get a prompt run by ID |


## `createPromptRun()`

```php
createPromptRun($slug, $version, $CreatePromptRun): \PromptJuggler\Client\Model\CreatePromptRunResponse
```

Create and trigger a prompt run

Triggers an asynchronous prompt run with the given inputs and returns a run ID and thread ID. Reference the prompt by version number, tag, or `__latest__`. Pass a thread ID to continue an existing conversation.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer authorization: Bearer
$config = PromptJuggler\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new PromptJuggler\Client\Api\PromptRunsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug = 'slug_example'; // string | Prompt Handle
$version = new \PromptJuggler\Client\Model\\PromptJuggler\Client\Model\GetPromptRevisionVersionParameter(); // \PromptJuggler\Client\Model\GetPromptRevisionVersionParameter | Specific version or tag or id
$CreatePromptRun = new \PromptJuggler\Client\Model\CreatePromptRun(); // \PromptJuggler\Client\Model\CreatePromptRun

try {
    $result = $apiInstance->createPromptRun($slug, $version, $CreatePromptRun);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PromptRunsApi->createPromptRun: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug** | **string**| Prompt Handle | |
| **version** | **\PromptJuggler\Client\Model\GetPromptRevisionVersionParameter**| Specific version or tag or id | |
| **CreatePromptRun** | [**\PromptJuggler\Client\Model\CreatePromptRun**](../Model/CreatePromptRun.md)|  | |

### Return type

[**\PromptJuggler\Client\Model\CreatePromptRunResponse**](../Model/CreatePromptRunResponse.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getPromptRun()`

```php
getPromptRun($id): \PromptJuggler\Client\Model\PromptRun
```

Get a prompt run by ID

Retrieves the current state of a prompt run, including status, outputs, token usage, cost, and errors. Poll this endpoint after receiving a webhook notification, or use it to check the status of a run in progress.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer authorization: Bearer
$config = PromptJuggler\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new PromptJuggler\Client\Api\PromptRunsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$id = 'id_example'; // string | Prompt run ID

try {
    $result = $apiInstance->getPromptRun($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PromptRunsApi->getPromptRun: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Prompt run ID | |

### Return type

[**\PromptJuggler\Client\Model\PromptRun**](../Model/PromptRun.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
