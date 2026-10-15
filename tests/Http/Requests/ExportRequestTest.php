<?php

declare(strict_types=1);

namespace JustBetter\ReplicatorTransfer\Tests\Http\Requests;

use JustBetter\ReplicatorTransfer\Http\Requests\ExportRequest;
use JustBetter\ReplicatorTransfer\Tests\TestCase;

final class ExportRequestTest extends TestCase
{
    public function test_it_authorizes_the_request(): void
    {
        $request = new ExportRequest;

        $this->assertTrue($request->authorize());
    }

    public function test_it_defines_validation_rules(): void
    {
        $request = new ExportRequest;

        $this->assertSame([
            'value' => ['required', 'array'],
            'value.*' => [],
            'meta' => ['nullable', 'array'],
        ], $request->rules());
    }
}
