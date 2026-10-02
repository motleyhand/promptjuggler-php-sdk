<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use PromptJuggler\Client\Models\CreatePromptRun;
use PromptJuggler\Client\Models\CreateWorkflowRunResponse;
use PromptJuggler\Client\Models\PromptRun;
use ReflectionMethod;
use UnexpectedValueException;

final class RequiredFieldsTest extends SdkTestCase
{
    public function testRequiredResponseFieldsAreNotNullable(): void
    {
        self::assertFalse(self::allowsNull(CreateWorkflowRunResponse::class, 'getId'));
        self::assertFalse(self::allowsNull(PromptRun::class, 'getStatus'));
        self::assertFalse(self::allowsNull(PromptRun::class, 'getTranscript'));
    }

    public function testOptionalResponseFieldsStayNullable(): void
    {
        self::assertTrue(self::allowsNull(PromptRun::class, 'getOutput'));
    }

    public function testRequestBodyFieldsStayNullable(): void
    {
        self::assertTrue(self::allowsNull(CreatePromptRun::class, 'getInputs'));
    }

    public function testRequiredFieldMissingFromTheResponseThrowsOnRead(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['thread' => 'thr_1'])]);
        $created = $pj->runWorkflow('pipeline', 7, inputs: []);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Required field CreateWorkflowRunResponse.id is missing from the API response.');
        $created->getId();
    }

    /**
     * @param class-string $class
     */
    private static function allowsNull(string $class, string $getter): ?bool
    {
        return (new ReflectionMethod($class, $getter))->getReturnType()?->allowsNull();
    }
}
