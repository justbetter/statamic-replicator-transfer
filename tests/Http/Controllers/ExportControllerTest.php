<?php

declare(strict_types=1);

namespace JustBetter\ReplicatorTransfer\Tests\Http\Controllers;

use JustBetter\ReplicatorTransfer\Http\Controllers\ExportController;
use JustBetter\ReplicatorTransfer\Http\Requests\ExportRequest;
use JustBetter\ReplicatorTransfer\Tests\TestCase;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class ExportControllerTest extends TestCase
{
    public function test_it_streams_the_export_payload_as_json(): void
    {
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

        $request = ExportRequest::create('/replicator-transfer/export', 'POST', $payload);

        $response = (new ExportController)->__invoke($request);

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertSame('attachment; filename=export.json', $response->headers->get('content-disposition'));
        $this->assertSame('application/json', $response->headers->get('content-type'));

        ob_start();
        $response->sendContent();
        $content = ob_get_clean();

        $this->assertJsonStringEqualsJsonString(json_encode($payload, JSON_THROW_ON_ERROR), (string) $content);
    }
}
