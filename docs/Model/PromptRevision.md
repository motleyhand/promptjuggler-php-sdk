# PromptRevision

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Prompt revision ID. |
**promptId** | **string** | Prompt ID. |
**memory** | [**\OpenAPI\Client\Model\Memory**](Memory.md) | Memory mode. |
**provider** | [**\OpenAPI\Client\Model\Provider**](Provider.md) | AI provider. |
**model** | [**\OpenAPI\Client\Model\Model**](Model.md) | AI model. |
**modelParams** | [**\OpenAPI\Client\Model\ModelParams**](ModelParams.md) | Model parameters. |
**responseFormat** | [**\OpenAPI\Client\Model\ResponseFormat**](ResponseFormat.md) | AI model response format. |
**systemInstruction** | **string** | The system prompt. | [optional]
**messages** | [**\OpenAPI\Client\Model\ContentMessageResponse[]**](ContentMessageResponse.md) | User and assistant messages. |
**tools** | [**\OpenAPI\Client\Model\Tool[]**](Tool.md) | Available tools. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
