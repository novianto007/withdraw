<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CircuitBreaker
{

    public static $maxError = 25;
    public static $maxDelay = 600;

    public static function isAvailable(string $serviceName, int $threshold): bool
    {
        $status = Cache::get('status.' . $serviceName);
        if ($status == null || $status == 'closed') {
            if (Cache::get('attemps.' . $serviceName) < $threshold) {
                Cache::increment('attemps.' . $serviceName);
                return true;
            }
            return false;
        }

        if ($status == 'opened') {
            if (Cache::get('lock.' . $serviceName) || Cache::get('half-open-onprocess.' . $serviceName)) {
                return false;
            }
            Cache::put('half-open-onprocess.' . $serviceName, true);
            Cache::increment('attemps.' . $serviceName);
            return true;
        }

        if($status == 'half-open'){
            if (Cache::get('lock.' . $serviceName) || Cache::get('half-open-onprocess.' . $serviceName)) {
                return false;
            }
            Cache::put('half-open-onprocess.' . $serviceName, true);
            Cache::increment('attemps.' . $serviceName);
            return true;
        }
    }

    public static function success(string $serviceName)
    {
        Cache::decrement('attemps.' . $serviceName);
        if (Cache::get('errors.' . $serviceName, 0) > 0) {
            Cache::decrement('errors.' . $serviceName);
        }

        if (Cache::get('status.' . $serviceName) == 'opened'){
            Cache::put('status.' . $serviceName, 'half-open');
        }

        if (Cache::get('status.' . $serviceName) == 'half-open') {
            $lockDelay = Cache::get('delay.' . $serviceName);
            $lockDelay = ($lockDelay > 60) ? intval($lockDelay / 2) : 0;
            if (Cache::get('errors.' . $serviceName) == 0 || $lockDelay == 0) {
                Cache::put('status.' . $serviceName, 'closed');
            }else{
                Cache::put('lock.' . $serviceName, true, $lockDelay);
                Cache::put('delay.' . $serviceName, $lockDelay);
            }
        }

        if(Cache::get('half-open-onprocess.' . $serviceName)){
            Cache::put('half-open-onprocess.' . $serviceName, false);
        }
    }

    public static function failed(string $serviceName)
    {
        Cache::decrement('attemps.' . $serviceName);
        Cache::increment('errors.' . $serviceName);
        if (Cache::get('errors.' . $serviceName) >= self::$maxError) {
            Cache::put('status.' . $serviceName, 'opened');
        }

        if (Cache::get('status.' . $serviceName) == 'opened' || Cache::get('status.' . $serviceName) == 'half-open') {
            $lockDelay = Cache::get('delay.' . $serviceName, 60);
            $lockDelay = ($lockDelay < self::$maxDelay) ? $lockDelay + 60 : self::$maxDelay;
            Cache::put('lock.' . $serviceName, true, $lockDelay);
            Cache::put('delay.' . $serviceName, $lockDelay);
        }

        if(Cache::get('half-open-onprocess.' . $serviceName)){
            Cache::put('half-open-onprocess.' . $serviceName, false);
        }
    }
}
