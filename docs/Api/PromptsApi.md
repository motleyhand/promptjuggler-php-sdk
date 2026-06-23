# PromptJuggler\Client\PromptsApi

All URIs are relative to https://promptjuggler.com/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getPromptRevision()**](PromptsApi.md#getPromptRevision) | **GET** /api/v1/prompts/{slug}/{version} | Get a prompt revision by the prompt’s slug and version |


## `getPromptRevision()`

```php
getPromptRevision($slug, $version): \PromptJuggler\Client\Model\PromptRevision
```

Get a prompt revision by the prompt’s slug and version

Retrieves the full configuration of a prompt revision including model, parameters, tool calls, messages.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer authorization: Bearer
$config = PromptJuggler\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new PromptJuggler\Client\Api\PromptsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug = 'slug_example'; // string | Prompt Handle
$version = new \PromptJuggler\Client\Model\\PromptJuggler\Client\Model\GetPromptRevisionVersionParameter(); // \PromptJuggler\Client\Model\GetPromptRevisionVersionParameter | Specific version or tag or id

try {
    $result = $apiInstance->getPromptRevision($slug, $version);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PromptsApi->getPromptRevision: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug** | **string**| Prompt Handle | |
| **version** | **\PromptJuggler\Client\Model\GetPromptRevisionVersionParameter**| Specific version or tag or id | |

### Return type

[**\PromptJuggler\Client\Model\PromptRevision**](../Model/PromptRevision.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
