<?php

namespace App\Providers;

use App;
use App\Models\AttributeSet;
use Cookie;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Torann\GeoIP\Facades\GeoIP;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        $this->setLanguage();
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

    public function setLanguage() {
        $encrypter = app(\Illuminate\Contracts\Encryption\Encrypter::class);

        try{
            $cookie = $encrypter->decrypt(Cookie::get('lang'));
        } catch(\Exception $e) {
            $coookie = null;
        }

        $ip = \Request::ip();
        $geo = GeoIP::getLocation($ip);
        $country = $geo['country'];

        $languages = [
            'Montenegro' => 'sr',
            'Serbia' => 'sr',
            'Bosnia and Herzegovina' => 'sr',
            'Croatia' => 'sr',
            'United States' => 'en',
            'United Kingdom' => 'en'
        ];


        if(isset($cookie) && !empty($cookie)) {
            App::setLocale($cookie);
        }else {
            if (array_key_exists($country, $languages)) {
                $lang = $languages[$country];
                App::setLocale($lang);
            }
            else {
                App::setLocale(App::getLocale());
            }
        }
    }
}
