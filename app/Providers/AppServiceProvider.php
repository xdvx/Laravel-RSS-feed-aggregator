<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FeedsManagerService;
use App\Services\RssParseService;
use View;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('database.default') == 'sqlite') {
            DB::statement(DB::raw('PRAGMA foreign_keys = ON;'));
        }

        View::composer('admin.*', function ($view) {
            $view->with('module', 'admin');
        });

        $this->app->singleton(FeedsManagerService::class, function () {
            return new FeedsManagerService();
        });

        $this->app->bind(RssParseService::class, function () {
           return new RssParseService();
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
