<?php

declare(strict_types=1);

namespace JustBetter\ReplicatorTransfer\Http\Controllers;

use JustBetter\ReplicatorTransfer\Http\Requests\ExportRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController
{
    public function __invoke(ExportRequest $request): StreamedResponse
    {
        return response()->streamDownload(function () use ($request): void {
            echo json_encode(
                $request->all(),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            );
        }, 'export.json', [
            'Content-Type' => 'application/json',
        ]);
    }
}
