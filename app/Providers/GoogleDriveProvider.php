<?php

namespace App\Providers;

use Google\Service\Storage;
use Illuminate\Support\ServiceProvider;

class GoogleDriveProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Storage::extend('google', function ($app, $config) {
            $client = new \Google_Client();
            $client->setClientId($config['client_id']);
            $client->setClientSecret($config['client_secret']);
            $client->setAccessToken($config['accessToken']);
            $client->refreshToken($config['refreshToken']);

            $service = new \Google_Service_Drive($client);

            $adapter = new \Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter($service, $config['folder_id']);
            
            return new \League\Flysystem\Filesystem($adapter);
        });
    }
}
