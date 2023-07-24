<?php

declare(strict_types=1);

namespace Task1\CommissionTask\Service;

use Exception;

Class Converter{

    private $rates;

    public function __construct(float $eur, float $usd, float $jpy)
    {
        $this->rates = [
            'EUR' => $eur,
            'USD' => $usd,
            'JPY' => $jpy,
        ];
    }

    public function convertToEuros(float $amount, string $currency) : float
    {
        if(!array_key_exists($currency, $this->rates)){
            throw new Exception("Currency not supported for client");
        }
        return $amount / $this->rates[$currency];
    }

    public function convertFromEuros(float $amount, string $currency): float
    {
        return $amount * $this->rates[$currency];
    }
}