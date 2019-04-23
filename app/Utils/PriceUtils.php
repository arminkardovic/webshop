<?php


namespace App\Utils;


use App\Models\LocationSettings;

class PriceUtils
{
    public static function formatPrice($price)
    {
        if (\Auth::guest() || !isset(\Auth::user()->locationSettings) || !isset(\Auth::user()->locationSettings->currency)) return floatval(number_format($price, 2, '.', ''));

        $locationSettings = \Auth::user()->locationSettings;

        if ($locationSettings->currency === "EUR") return floatval(number_format($price, 2, '.', ''));

        $price = $price / $locationSettings->exchange_rate;
        return floatval(number_format($price, 2, '.', ''));
    }

    public static function formattedPrice($price) {
        $price = PriceUtils::formatPrice($price);

        if (\Auth::guest())
            $currency = 'EUR';
        else
            $currency = \Auth::user()->locationSettings->currency;

        switch ($currency) {
            case 'EUR':
                $currency = '€';
                break;
            case 'USD':
                $currency = '$';
                break;
            case 'RSD':
                $currency = 'din.';
                break;
            default;
                break;
        }

        return $price . ' ' . $currency;
    }
}