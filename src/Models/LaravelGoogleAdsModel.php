<?php

namespace LucasGiovanny\LaravelGoogleAds\Models;

class LaravelGoogleAdsModel
{
    /**
     * Construct the resource model with attributes
     *
     *
     * @return void
     */
    public function __construct(public string $resource, public ?array $attributes = null)
    {
    }

    /**
     * Magic method to return attribute as property
     *
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }
}
