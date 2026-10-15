<?php

declare(strict_types=1);

namespace JustBetter\ReplicatorTransfer\Tests\Http\Requests;

use JustBetter\ReplicatorTransfer\Http\Requests\ImportRequest;
use JustBetter\ReplicatorTransfer\Tests\TestCase;

final class ImportRequestTest extends TestCase
{
    public function test_it_authorizes_the_request(): void
    {
        $request = new ImportRequest;

        $this->assertTrue($request->authorize());
    }

    public function test_it_defines_validation_rules(): void
    {
        $request = new ImportRequest;

        $this->assertSame([
            'file' => ['required', 'string'],
        ], $request->rules());
    }
}
