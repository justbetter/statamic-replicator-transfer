<?php

declare(strict_types=1);

namespace JustBetter\ReplicatorTransfer\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use JustBetter\ReplicatorTransfer\Http\Requests\ImportRequest;

class ImportController
{
    public function __invoke(ImportRequest $request): JsonResponse
    {
        $path = 'statamic/file-uploads/'.$request->string('file')->toString();

        abort_unless(
            Storage::disk('local')->exists($path),
            404,
            'Import file not found.'
        );

        $contents = Storage::disk('local')->get($path);

        abort_if($contents === null, 404, 'Import file not found.');

        $data = json_decode(
            $contents,
            true,
            512,
            JSON_THROW_ON_ERROR,
        );

        Storage::disk('local')->delete($path);

        return response()->json($data);
    }
}
