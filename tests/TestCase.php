<?php

namespace lucasgiovanny\LaravelGoogleAds\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lucasgiovanny\LaravelGoogleAds\LaravelGoogleAdsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'lucasgiovanny\\LaravelGoogleAds\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelGoogleAdsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        include_once __DIR__.'/../database/migrations/create_laravel-google-ads_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
