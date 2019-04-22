<?php

namespace App\Http\Middleware;

use App;
use App\Models\LocationSettings;
use App\User;
use Auth;
use Closure;
use Torann\GeoIP\Facades\GeoIP;

class LocationSettingsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->setLanguage();
        return $next($request);
    }


    public function setLanguage()
    {
        $user = Auth::user();

        /** @var User $user */

        if ($user) {

            if (!isset($user->location_settings_id)) {
                $locationSettings = $this->getLocationSettingsByIp();
                $user->location_settings_id = $locationSettings->id;
                $user->save();
            }

            $locale = $user->locationSettings->locale;
        } else {
            $locationSettings = $this->getLocationSettingsByIp();
            $locale = $locationSettings->locale;
        }

        App::setLocale($locale);
    }

    /**
     * @return mixed
     */
    private function getLocationSettingsByIp()
    {
        $ip = \Request::ip();
//        $ip = '37.0.66.201';
        $geo = GeoIP::getLocation($ip);
        $country = $geo['country'];

        if ($country == null) {
            $country = 'United States';
        }

        $locationSettings = LocationSettings::where('country', $country)->first();
        return $locationSettings;
    }
}
