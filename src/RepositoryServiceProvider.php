<?php

namespace Mmurattcann\RepositoryGenerator;

use Illuminate\Support\ServiceProvider;
use Mmurattcann\RepositoryGenerator\Helper\FileGetter;

class RepositoryServiceProvider extends ServiceProvider
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

        $helper = new FileGetter();

        $files = $helper->readFiles();

        foreach ($helper->readFiles() as $i => $class){

            $this->app->singleton("App\Repositories\Interfaces\\". $files["interfaces"][$i], "App\Repositories\Classes\\". $class);
        }
    }
}
