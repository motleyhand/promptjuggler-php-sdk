# OpenAPI\Client\WorkflowRunsApi

All URIs are relative to https://promptjuggler.com/api/v1.

Method | HTTP request | Description
------------- | ------------- | -------------
[**createWorkflowRun()**](WorkflowRunsApi.md#createWorkflowRun) | **POST** /api/v1/workflows/{slug}/{version}/runs | Create and trigger a workflow run
[**getWorkflowRun()**](WorkflowRunsApi.md#getWorkflowRun) | **GET** /api/v1/workflowruns/{id} | Get a workflow run by ID


## `createWorkflowRun()`

```php
createWorkflowRun($slug, $version, $CreateWorkflowRun): \OpenAPI\Client\Model\CreateWorkflowRunResponse
```

Create and trigger a workflow run

Triggers an asynchronous workflow run with the given inputs and returns a run ID and thread ID. Reference the workflow by version number, tag, or `__latest__`. Pass a thread ID to continue an existing conversation across runs.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer authorization: Bearer
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WorkflowRunsApi(
    // If you want use custom http client, pass your client which implements `Psr\Http\Client\ClientInterface`.
    // This is optional, `Psr18ClientDiscovery` will be used to find http client. For instance `GuzzleHttp\Client` implements that interface
    new GuzzleHttp\Client(),
    $config
);
$slug = 'slug_example'; // string | Workflow Handle
$version = new \OpenAPI\Client\Model\\OpenAPI\Client\Model\GetPromptRevisionVersionParameter(); // \OpenAPI\Client\Model\GetPromptRevisionVersionParameter | Specific version or tag or id
$CreateWorkflowRun = new \OpenAPI\Client\Model\CreateWorkflowRun(); // \OpenAPI\Client\Model\CreateWorkflowRun

try {
    $result = $apiInstance->createWorkflowRun($slug, $version, $CreateWorkflowRun);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WorkflowRunsApi->createWorkflowRun: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **slug** | **string**| Workflow Handle |
 **version** | **\OpenAPI\Client\Model\GetPromptRevisionVersionParameter**| Specific version or tag or id |
 **CreateWorkflowRun** | [**\OpenAPI\Client\Model\CreateWorkflowRun**](../Model/CreateWorkflowRun.md)|  |

### Return type

[**\OpenAPI\Client\Model\CreateWorkflowRunResponse**](../Model/CreateWorkflowRunResponse.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getWorkflowRun()`

```php
getWorkflowRun($id): \OpenAPI\Client\Model\WorkflowRun
```

Get a workflow run by ID

Retrieves the current state of a workflow run, including status, outputs, and errors. Poll this endpoint after receiving a webhook notification, or use it to check the status of a run in progress.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer authorization: Bearer
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WorkflowRunsApi(
    // If you want use custom http client, pass your client which implements `Psr\Http\Client\ClientInterface`.
    // This is optional, `Psr18ClientDiscovery` will be used to find http client. For instance `GuzzleHttp\Client` implements that interface
    new GuzzleHttp\Client(),
    $config
);
$id = 'id_example'; // string | Workflow run ID

try {
    $result = $apiInstance->getWorkflowRun($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WorkflowRunsApi->getWorkflowRun: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| Workflow run ID |

### Return type

[**\OpenAPI\Client\Model\WorkflowRun**](../Model/WorkflowRun.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
