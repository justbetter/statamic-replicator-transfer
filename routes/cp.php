<?php

use Illuminate\Support\Facades\Route;
use JustBetter\ReplicatorTransfer\Http\Controllers\ExportController;
use JustBetter\ReplicatorTransfer\Http\Controllers\ImportController;

Route::prefix('replicator-transfer')->group(function () {
    Route::post('/export', ExportController::class)->name('justbetter.replicator-transfer.export');
    Route::post('/import', ImportController::class)->name('justbetter.replicator-transfer.import');
});
