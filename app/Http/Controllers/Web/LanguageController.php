<?php

namespace App\Http\Controllers\Web;

use App;
use Cookie;
use Illuminate\Http\Request;

class LanguageController extends App\Http\Controllers\BaseController
{
    public function change($lang) {
        $languages = ['en', 'sr'];

        if(in_array($lang, $languages)) {

            Cookie::queue(Cookie::make('lang', $lang , '20160'));
            return back();

        } else {
            App::setLocale(App::getLocale());
            return back();
        }

    }
}
