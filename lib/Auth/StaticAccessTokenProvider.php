<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Auth;

use Http\Promise\FulfilledPromise;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\Authentication\AccessTokenProvider;
use Microsoft\Kiota\Abstractions\Authentication\AllowedHostsValidator;

/**
 * Supplies a static API key as the Bearer token, scoped to the PromptJuggler host
 * so the key is never attached to requests bound elsewhere.
 */
final class StaticAccessTokenProvider implements AccessTokenProvider
{
    private readonly AllowedHostsValidator $allowedHostsValidator;

    public function __construct(private readonly string $accessToken)
    {
        $this->allowedHostsValidator = new AllowedHostsValidator(['promptjuggler.com']);
    }

    public function getAuthorizationTokenAsync(string $url, array $additionalAuthenticationContext = []): Promise
    {
        $token = $this->allowedHostsValidator->isUrlHostValid($url) ? $this->accessToken : '';

        return new FulfilledPromise($token);
    }

    public function getAllowedHostsValidator(): AllowedHostsValidator
    {
        return $this->allowedHostsValidator;
    }
}
