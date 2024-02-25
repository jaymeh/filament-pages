<?php

namespace Jaymeh\FilamentPages;

use Jaymeh\FilamentPages\Providers\RouteServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentPagesServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-pages';

    public static string $viewNamespace = 'filament-pages';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('jaymeh/filament-pages');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            '2023_11_15_144548_create_pages_table',
            '2024_02_14_105032_add_published_at_field',
        ];
    }

    public function register()
    {
        parent::register();

        $this->app->register(RouteServiceProvider::class);
    }
}
