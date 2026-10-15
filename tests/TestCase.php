<?php

declare(strict_types=1);

namespace JustBetter\ReplicatorTransfer\Tests;

use JustBetter\ReplicatorTransfer\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
