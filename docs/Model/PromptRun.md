# PromptRun

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Prompt run ID. |
**status** | [**\PromptJuggler\Client\Model\RunStatus**](RunStatus.md) | Current run status. |
**createdAt** | **\DateTime** | Timestamp when the run was created. |
**finishedAt** | **\DateTime** | Timestamp when the run finished. Null while the run is pending. | [optional]
**output** | **string** | LLM output text. Null while pending or when the run failed. | [optional]
**error** | **string** | Error message if the run failed. Null on success. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
