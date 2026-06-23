# CreateWorkflowRun

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**inputs** | **array<string,string>** | Key-value map of input variable names to their values. |
**thread** | **string** | Thread ID to continue a multi-turn conversation. Omit to start a new thread. | [optional]
**priority** | **string** | Processing priority. | [optional] [default to 'normal']
**environment** | **string** | Environment that scopes which webhooks fire and which environment variables the run can access. Uses the default environment when omitted. | [optional]
**envVars** | **array<string,string>** | Runtime environment variable overrides for this run. Keys must be UPPER_CASE. At most 50 entries, 64 KB total. | [optional]
**metadata** | [**array<string,\PromptJuggler\Client\Model\CreateWorkflowRunMetadataValue>**](CreateWorkflowRunMetadataValue.md) | Arbitrary key-value metadata attached to the run. Values can be strings or arrays of strings. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
