<?php

namespace CurrencyConverter\Console\Commands;

use Illuminate\Console\Command;
use CurrencyConverter\Libraries\CurrencyRateApi\Fetcher;

class FetchCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curr:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch currency rates for today.';

    private $fetcher;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Fetcher $fetcher)
    {
        parent::__construct();

        $this->fetcher = $fetcher;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->fetcher->isTodaysCurrencyRatesFetched()) {
            $this->info('Currency rates already fetched for today.');
            return;
        }

        $this->info('Fetching currency rates for today.');

        $this->fetcher->fetchLatestAndUdpate();

        $this->info('Done.');
    }
}
