<?php

use Illuminate\Database\Seeder;
use CurrencyConverter\Libraries\CurrencyRateApi\Fetcher;
use CurrencyConverter\Libraries\CurrencyRateApi\Client\ECPClient;

class CurrencyRatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new ECPClient();
        $fetcher = new Fetcher($client);
        $fetcher->fetchLatestAndUdpate();
    }
}
