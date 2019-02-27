<?php

namespace Spatie\ResponseCache\CacheProfiles;

use Illuminate\Support\Facades\Auth;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;

abstract class BaseCacheProfile implements CacheProfile
{
    public function enabled(Request $request): bool
    {
        return config('responsecache.enabled');
    }

    /*
     * Return the time when the cache must be invalided.
     */
    public function cacheRequestUntil(Request $request): DateTime
    {
        return Carbon::now()->addMinutes(
            config('responsecache.cache_lifetime_in_minutes')
        );
    }

    /*
     * Set a string to add to differentiate this request from others.
     */
    public function cacheNameSuffix(Request $request): string
    {
        if (Auth::check()) {
            return Auth::user()->id;
        }

        return '';
    }

    public function isRunningInConsole(): bool
    {
        if (app()->environment('testing')) {
            return false;
        }

        return app()->runningInConsole();
    }
}
