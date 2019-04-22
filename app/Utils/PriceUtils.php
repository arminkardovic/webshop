<?php


namespace App\Utils;


use App\Models\LocationSettings;

class PriceUtils
{
    public static function formatPrice($price)
    {
        if (!isset(\Auth::user()->locationSettings) || !isset(\Auth::user()->locationSettings->currency)) return floatval(number_format($price, 2, '.', ''));

        $locationSettings = \Auth::user()->locationSettings;

        if ($locationSettings->currency === "EUR") return floatval(number_format($price, 2, '.', ''));

        $price = $price / $locationSettings->exchange_rate;
        return floatval(number_format($price, 2, '.', ''));
    }
}