<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class ApiClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('api-client', function () {
            $options = [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'base_uri' => env('SBIG_API_URL'),
                'auth' => [
                    env('SBIG_BASIC_TOKEN'), ''
                ]
            ];
            return new Client($options);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
