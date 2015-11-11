<?php

namespace CurrencyConverter\Libraries\CurrencyRateApi\Client;

use CurrencyConverter\Libraries\CurrencyRateApi\Domain\Rate;
use Log;

class ECPClient implements Client
{
    const URL = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';


    public function fetch()
    {
        $data = $this->fetchXML();
        $xml = $this->parse($data);
        $rates = $this->createRates($xml);

        return $rates;
    }


    private function fetchXML()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => self::URL,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    private function parse($xmlString)
    {
        return simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
    }

    private function createRates($xml)
    {
        $rates = [];

        $date = (string) $xml->Cube->Cube['time'];

        foreach ($xml->Cube->Cube->Cube as $rateEl) {
            $rate = new Rate;
            $rate->currency = (string) $rateEl['currency'];
            $rate->rate = (string) $rateEl['rate'];
            $rate->date = $date;

            Log::info('Fetched currency rate: ' . $rate);

            $rates[] = $rate;
        }

        return $rates;
    }
}
