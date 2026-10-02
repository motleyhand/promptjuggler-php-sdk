# PromptJuggler PHP SDK

The official PHP client for the [PromptJuggler](https://promptjuggler.com) API. Run
prompts and workflows, manage knowledge bases, and verify webhooks — fully typed, with
flat, synchronous methods.

## Requirements

- PHP 8.2+

## Installation

```bash
composer require promptjuggler/sdk
```

It sends requests through the PSR-18 HTTP client already in your project (Guzzle, Symfony
HttpClient, …). With none installed, `composer require guzzlehttp/guzzle`, or let Composer's
`php-http/discovery` plugin install one when it asks.

## Usage

```php
use PromptJuggler\Client\Models\Priority;
use PromptJuggler\Client\Models\RunStatus;
use PromptJuggler\Client\PromptJuggler;

$pj = new PromptJuggler('your-api-key');

// Trigger a run (async — returns the run ID)
$created = $pj->runPrompt('greeting', 'production', inputs: ['name' => 'Ada'], priority: Priority::Low);

// Poll for the result
$run = $pj->getPromptRun($created->id);
if ($run->status === RunStatus::Completed) {
    echo $run->output;
}
```

Results are readonly objects with public properties. Enum properties are typed
`RunStatus|UnknownEnumValue`: a value newer than the SDK arrives as `UnknownEnumValue`
instead of failing, and a `match` without a `default` arm throws `UnhandledMatchError` on
it, so keep one. `Tool`, `ResponseFormat` and `TranscriptItem` are interfaces; tell their
variants apart with `instanceof`.

The HTTP client is found automatically; pass one as the second argument to configure it
(`new PromptJuggler($key, new GuzzleHttp\Client(['timeout' => 10]))`), and a `baseUrl:` to target
another deployment. The API key is sent to whatever base URL is configured.

Errors surface as `ApiException` (with an `int $statusCode`), `NetworkException` (no complete
response), or `DecodeException` (a success body that doesn't decode, such as a missing required
field), all in `PromptJuggler\Client\Exception` and implementing `PromptJugglerException`. The
SDK doesn't retry. Verify incoming webhooks with
`PromptJuggler\Client\Webhook\WebhookSignature::isValid()`.

## Documentation

Full guides and the API reference: **https://docs.promptjuggler.com/sdks/php/overview**

## License

MIT
