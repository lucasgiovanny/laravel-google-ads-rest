<?php

namespace lucasgiovanny\LaravelGoogleAds\Facades;

use Illuminate\Support\Facades\Facade;
use lucasgiovanny\LaravelGoogleAds\LaravelGoogleAds as GoogleAdsService;

/**
* @see lucasgiovanny\LaravelGoogleAds\LaravelGoogleAds
*/
class GoogleAds extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return GoogleAdsService::class;
    }
}
