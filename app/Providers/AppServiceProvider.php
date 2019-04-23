<?php

namespace App\Providers;

use App;
use App\Models\AttributeSet;
use App\Models\LocationSettings;
use App\Models\ProductPrice;
use App\User;
use App\Utils\PriceUtils;
use Auth;
use Cookie;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Torann\GeoIP\Facades\GeoIP;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

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
        //

    }


}
