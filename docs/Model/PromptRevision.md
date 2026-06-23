# PromptRevision

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Prompt revision ID. |
**promptId** | **string** | Prompt ID. |
**memory** | [**\PromptJuggler\Client\Model\Memory**](Memory.md) | Memory mode. |
**provider** | [**\PromptJuggler\Client\Model\Provider**](Provider.md) | AI provider. |
**model** | [**\PromptJuggler\Client\Model\Model**](Model.md) | AI model. |
**modelParams** | [**\PromptJuggler\Client\Model\ModelParams**](ModelParams.md) | Model parameters. |
**responseFormat** | [**\PromptJuggler\Client\Model\ResponseFormat**](ResponseFormat.md) | AI model response format. |
**systemInstruction** | **string** | The system prompt. | [optional]
**messages** | [**\PromptJuggler\Client\Model\ContentMessageResponse[]**](ContentMessageResponse.md) | User and assistant messages. |
**tools** | [**\PromptJuggler\Client\Model\Tool[]**](Tool.md) | Available tools. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
