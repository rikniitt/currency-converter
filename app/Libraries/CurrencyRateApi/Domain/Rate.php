<?php

namespace CurrencyConverter\Libraries\CurrencyRateApi\Domain;


class Rate
{

    public $date;

    public $currency;
    
    public $rate;

    public function __toString()
    {
        return $this->currency . ' ' . $this->rate . ' (' . $this->date . ')';
    }
}
