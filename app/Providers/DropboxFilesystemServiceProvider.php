<?php

namespace App\Providers;

use Storage;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
// use League\Flysystem\Dropbox\DropboxAdapter;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Illuminate\Support\ServiceProvider;

class DropboxFilesystemServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Storage::extend('dropbox', function ($app, $config) {
        //     $client = new DropboxClient($config['accessToken'], $config['appSecret']);

        //     return new Filesystem(new DropboxAdapter($client));
        // });
        Storage::extend('dropbox', function ($app, $config) {
            $client = new DropboxClient($config['accessToken']);

            return new Filesystem(new DropboxAdapter($client));
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
