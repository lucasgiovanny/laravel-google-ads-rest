<?php

namespace lucasgiovanny\LaravelGoogleAds\Commands;

use Illuminate\Console\Command;

class LaravelGoogleAdsCommand extends Command
{
    public $signature = 'laravel-google-ads';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
