# PromptJuggler PHP SDK

A typed PHP client for the [PromptJuggler](https://promptjuggler.com) API — run
prompts and workflows, manage knowledge bases, and verify webhooks.

> Generated with [Kiota](https://learn.microsoft.com/openapi/kiota/) and fronted by
> a hand-written facade. **Do not edit `src/`** — it is regenerated from the OpenAPI
> spec. The public API lives in `lib/`.

## Requirements

- PHP 8.1+

## Installation

```bash
composer require promptjuggler/sdk
```

## Usage

```php
use PromptJuggler\Client\PromptJuggler;
use PromptJuggler\Client\Models\RunStatus;

$pj = new PromptJuggler('your-api-key');

// Trigger a run (async — returns the run ID)
$created = $pj->runPrompt('greeting', 'production', inputs: ['name' => 'Ada']);

// Poll for the result
$run = $pj->getPromptRun($created->getId());
if ($run->getStatus()?->is(RunStatus::COMPLETED)) {
    echo $run->getOutput();
}
```

Errors surface as `PromptJuggler\Client\Exception\ApiException` (with a `statusCode`).
Verify incoming webhooks with `PromptJuggler\Client\Webhook\WebhookSignature::isValid()`.

## Documentation

Full guides and the API reference: **https://docs.promptjuggler.com/sdks/php/overview**

## License

MIT
