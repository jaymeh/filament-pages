<?php

namespace Jaymeh\FilamentPages;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Jaymeh\FilamentPages\Filament\Resources\PageResource;

class FilamentPagesPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-pages';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                PageResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
