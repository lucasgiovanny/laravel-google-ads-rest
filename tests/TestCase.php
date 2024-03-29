<?php

namespace LucasGiovanny\LaravelGoogleAds\Tests;

use LucasGiovanny\LaravelGoogleAds\LaravelGoogleAdsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelGoogleAdsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        /*
        include_once __DIR__.'/../database/migrations/create_laravel-google-ads_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
