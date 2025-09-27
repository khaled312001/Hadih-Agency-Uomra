<?php

namespace App\Helpers;

class CurrencyHelper
{
    public static function getCurrencyImage($currency)
    {
        $currency = strtolower($currency);
        $imagePath = "images/currencies/{$currency}.svg";
        
        // Check if file exists, otherwise return default
        if (file_exists(public_path($imagePath))) {
            return asset($imagePath);
        }
        
        return asset("images/currencies/sar.svg"); // Default to SAR
    }
    
    public static function getCurrencyName($currency)
    {
        $currencies = [
            'SAR' => 'ريال سعودي',
            'USD' => 'دولار أمريكي',
            'EUR' => 'يورو',
            'GBP' => 'جنيه إسترليني',
            'AED' => 'درهم إماراتي',
            'KWD' => 'دينار كويتي',
            'QAR' => 'ريال قطري',
            'BHD' => 'دينار بحريني',
            'OMR' => 'ريال عماني',
        ];
        
        return $currencies[$currency] ?? $currency;
    }
    
    public static function formatPrice($amount, $currency = 'SAR')
    {
        return number_format($amount, 2) . ' ' . $currency;
    }
}
