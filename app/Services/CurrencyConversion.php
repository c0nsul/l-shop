<?php

namespace App\Services;

use App\Models\Currency;

class CurrencyConversion
{
    protected static $container;

    public static function loadContainer()
    {
        if (is_null(self::$container)) {
            $currencies = Currency::get();
            foreach ($currencies as $currency) {
                self::$container[$currency->code] = $currency;
            }
        }
    }

    /**
     * @return mixed
     */
    public static function getCurrencies()
    {
        return self::$container;
    }

    /**
     * @param $sum
     * @param string $originCurrencyCode
     * @param null $targetCurrencyCode
     * @return float|int
     */
    public static function convert($sum, string $originCurrencyCode = 'RUB', $targetCurrencyCode = null)
    {
        self::loadContainer();

        $originCurrency = self::$container[$originCurrencyCode];

        if (is_null($targetCurrencyCode)) {
            $targetCurrencyCode = session('currency', 'RUB');
        }
        $targetCurrency = self::$container[$targetCurrencyCode];

        return $sum * $originCurrency->rate / $targetCurrency->rate;
    }

    /**
     * @return mixed
     */
    public static function getCurrencySymbol()
    {
        self::loadContainer();

        $currencyFromSession = session('currency', 'RUB');

        $currency = self::$container[$currencyFromSession];
        return $currency->symbol;
    }
}
