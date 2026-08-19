<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

final class FightServiceProvider extends ServiceProvider
{
    /**
     * Framework-specific bindings for public Fight package contracts belong here.
     *
     * The bootstrap intentionally installs no login or persistence binding.
     */
    public function register(): void {}
}
