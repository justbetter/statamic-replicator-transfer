<?php

declare(strict_types=1);

namespace JustBetter\ReplicatorTransfer;

use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;

class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [
        'input' => [
            'resources/js/cp.js',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    public function register(): void
    {
        parent::register();

        $this->mergeConfigFrom(__DIR__.'/../config/replicator-transfer.php', 'replicator-transfer');
    }

    public function boot(): void
    {
        parent::boot();

        $this->bootConfig()
            ->bootScriptData();
    }

    protected function bootConfig(): static
    {
        $this->publishes([
            __DIR__.'/../config/replicator-transfer.php' => config_path('replicator-transfer.php'),
        ], 'replicator-transfer-config');

        return $this;
    }

    protected function bootScriptData(): static
    {
        Statamic::provideToScript([
            'replicatorTransferHandles' => config('replicator-transfer.handles'),
        ]);

        return $this;
    }
}
