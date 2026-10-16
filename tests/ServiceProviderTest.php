<?php

declare(strict_types=1);

namespace JustBetter\ReplicatorTransfer\Tests;

final class ServiceProviderTest extends TestCase
{
    public function test_it_merges_the_default_handles(): void
    {
        $this->assertSame(['page_builder'], config('replicator-transfer.handles'));
    }
}
