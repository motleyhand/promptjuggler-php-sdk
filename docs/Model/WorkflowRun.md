# WorkflowRun

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Workflow run ID. |
**status** | [**\OpenAPI\Client\Model\RunStatus**](RunStatus.md) | Current run status. |
**createdAt** | **\DateTime** | Timestamp when the run was created. |
**finishedAt** | **\DateTime** | Timestamp when the run finished. Null while the run is pending. | [optional]
**outputs** | **array<string,string>** | Map of output node names to their values. Empty object while pending. |
**errors** | **string[]** | List of error messages from failed nodes. Empty array on success. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
