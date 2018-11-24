<?php

namespace App\Providers;

use function foo\func;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		Schema::defaultStringLength(191);
		View::composer('*', function($view) {
			$view->with('channels', \App\Models\Channel::all());
		});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    	if($this->app->isLocal())
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
    }


}
