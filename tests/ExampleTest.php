<?php

namespace lucasgiovanny\LaravelGoogleAds\Tests;

use lucasgiovanny\LaravelGoogleAds\Facades\GoogleAds;

class ExampleTest extends TestCase
{
    /** @test */
    public function true_is_true()
    {
        $tt = GoogleAds::account("6697289151")->select("customer.id")->from('customer')->where("segments.date", "DURING", "LAST_7_DAYS")->get();

        dd($tt);
    }
}
