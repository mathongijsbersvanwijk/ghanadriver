<?php

namespace App\Providers;

use App\Business\Articles;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*     	$this->app->singleton('articleservice', function ($app) {
         return new ArticleService();
         });
         */
        $this->app->singleton('articles', function ($app) {
            return new Articles();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
