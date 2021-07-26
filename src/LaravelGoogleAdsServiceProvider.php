<?php

namespace lucasgiovanny\LaravelGoogleAds;

use lucasgiovanny\LaravelGoogleAds\Commands\LaravelGoogleAdsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelGoogleAdsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-google-ads')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-google-ads_table')
            ->hasCommand(LaravelGoogleAdsCommand::class);
    }
}
