<?php

namespace LucasGiovanny\LaravelGoogleAds\Facades;

use Illuminate\Support\Facades\Facade;
use LucasGiovanny\LaravelGoogleAds\LaravelGoogleAds as GoogleAdsService;

/**
 * @see LucasGiovanny\LaravelGoogleAds\LaravelGoogleAds
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
