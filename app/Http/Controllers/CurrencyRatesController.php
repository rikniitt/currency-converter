<?php

namespace CurrencyConverter\Http\Controllers;

use Illuminate\Http\Request;

use CurrencyConverter\Http\Requests;
use CurrencyConverter\Http\Controllers\Controller;
use CurrencyConverter\CurrencyRate;
use CurrencyConverter\Libraries\CurrencyRateApi\Fetcher;
use Log;

class CurrencyRatesController extends Controller
{
    
    public function __construct(Fetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->fetcher->isTodaysCurrencyRatesFetched()) {
            $this->fetcher->fetchLatestAndUpdate();
        }

        $rates = CurrencyRate::with('currency')->latest()->orderBy('currency_id')->get();

        if ($rates->count() === 0) {
            Log::error("Didn't find any currency rates for displaying!");
            abort(503, 'Currency rates unavailable!');
        }

        $latest_update = CurrencyRate::getMaxForDate();

        return view('index', [
            'rates' => $rates,
            'latest_update' => $latest_update
        ]);
    }
}
