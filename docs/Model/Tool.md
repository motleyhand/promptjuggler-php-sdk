# Tool

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | **string** |  |
**allowedDomains** | **string[]** |  | [optional]
**paramsSchema** | **string** | JSON schema of the parameters this tool expects. |
**url** | **string** | The URL of the MCP server. |
**method** | **string** |  |
**headers** | [**\PromptJuggler\Client\Model\HttpHeader[]**](HttpHeader.md) | The headers to send with the HTTP request. Can contain ${ENV_VAR} and {{inputName}} placeholders. | [optional] [default to []]
**name** | **string** | The tool’s name. |
**description** | **string** | The tool’s description. | [optional]
**failFast** | **bool** | Whether to stop processing if a tool call fails. | [optional] [default to false]
**language** | **string** | The language of the script to execute. |
**code** | **string** | The script that this tool executes. |
**authorizationToken** | **string** | Authorization token for the MCP server. | [optional]
**allowedTools** | **string[]** | Tool names the model may call. Empty or omitted allows all of the server’s tools. | [optional]
**versionRef** | [**\PromptJuggler\Client\Model\VersionRef**](VersionRef.md) | Referencing the workflow revision either by id or version number or tag. |
**knowledgeBaseId** | **string** |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
