<?php

namespace CurrencyConverter\Libraries\CurrencyRateApi;

use Carbon\Carbon;
use CurrencyConverter\Libraries\CurrencyRateApi\Client\Client;
use CurrencyConverter\CurrencyRate;
use CurrencyConverter\Currency;
use CurrencyConverter\Libraries\CurrencyRateApi\Domain\Rate;

class Fetcher
{

    private $client;


    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function isTodaysCurrencyRatesFetched()
    {
        return CurrencyRate::forToday()->count() > 0;
    }

    public function fetchLatestAndUdpate()
    {
        $rates = $this->fetchCurrencyRates();

        if (count($rates) > 0) {

            // Add euro rate
            $euro = new Rate();
            $euro->currency = 'EUR';
            $euro->rate = '1.0';
            $euro->date = $rates[0]->date;

            $rates[] = $euro;
        }


        $this->createOrUpdate($rates);
    }

    private function fetchCurrencyRates()
    {
        return $this->client->fetch();
    }

    private function createOrUpdate($rates)
    {
        foreach ($rates as $r) {
            $date = Carbon::createFromFormat('Y-m-d', $r->date);
            $start_of_day = $date->startOfDay();

            $rate = Currency::where('currency', $r->currency)
                            ->first()->rates()
                            ->forDate($start_of_day)->first();

            if (!$rate) {
                $currency = Currency::where('currency', $r->currency)->first();
                CurrencyRate::create([
                    'currency_id' => $currency->id,
                    'rate' => $r->rate,
                    'for_date' => $start_of_day,
                ]);
            } else {
                $rate->rate = $r->rate;
                $rate->save();
            }
        }
    }
}
