<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * A reference to a revision.
 */
final readonly class VersionRef
{
    /**
     * @param string $definitionId Definition – prompt or workflow – ID.
     * @param int|string $idOrTag Revision ID or version number or tag.
     */
    public function __construct(
        public string $definitionId,
        public int|string $idOrTag,
    ) {
    }
}
