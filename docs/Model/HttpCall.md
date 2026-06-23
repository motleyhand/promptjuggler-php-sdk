# HttpCall

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**paramsSchema** | **string** | JSON schema of the parameters this tool expects. |
**url** | **string** | The URL to call. Can contain ${ENV_VAR} and {{inputName}} placeholders. |
**method** | **string** |  |
**headers** | [**\OpenAPI\Client\Model\HttpHeader[]**](HttpHeader.md) | The headers to send with the HTTP request. Can contain ${ENV_VAR} and {{inputName}} placeholders. | [optional]
**name** | **string** | The tool’s name. |
**description** | **string** | The tool’s description. | [optional]
**failFast** | **bool** | Whether to stop processing if a tool call fails. | [optional] [default to false]
**type** | **string** |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
