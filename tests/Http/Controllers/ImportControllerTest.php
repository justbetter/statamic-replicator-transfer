<?php

declare(strict_types=1);

namespace JustBetter\ReplicatorTransfer\Tests\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use JustBetter\ReplicatorTransfer\Http\Controllers\ImportController;
use JustBetter\ReplicatorTransfer\Http\Requests\ImportRequest;
use JustBetter\ReplicatorTransfer\Tests\TestCase;

final class ImportControllerTest extends TestCase
{
    public function test_it_returns_uploaded_export_json_and_deletes_the_file(): void
    {
        Storage::fake('local');

        $payload = [
            'value' => [
                [
                    '_id' => 'set-id',
                    'type' => 'content',
                    'enabled' => true,
                ],
            ],
            'meta' => [
                'existing' => [
                    'set-id' => [
                        'heading' => [],
                    ],
                ],
            ],
        ];

        Storage::disk('local')->put('statamic/file-uploads/export.json', json_encode($payload, JSON_THROW_ON_ERROR));

        $request = ImportRequest::create('/replicator-transfer/import', 'POST', [
            'file' => 'export.json',
        ]);

        $response = (new ImportController)->__invoke($request);

        $this->assertSame($payload, $response->getData(true));
        Storage::disk('local')->assertMissing('statamic/file-uploads/export.json');
    }
}
