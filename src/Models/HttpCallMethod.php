<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum HttpCallMethod: string
{
    case Get = 'GET';
    case Post = 'POST';
    case Put = 'PUT';
    case Patch = 'PATCH';
    case Delete = 'DELETE';
}
