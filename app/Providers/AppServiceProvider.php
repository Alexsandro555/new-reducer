<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Product\Entities\ProductCategory;
use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      view()->composer('layouts.master', function($view) {
        $view->with('productCategory', ProductCategory::where('active', 1)->get());
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->singleton(FakerGenerator::class, function () {
        return FakerFactory::create('ru_RU');
      });
    }
}
