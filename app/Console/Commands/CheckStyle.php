<?php

namespace CurrencyConverter\Console\Commands;

use Illuminate\Console\Command;

class CheckStyle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curr:check-style';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run PHP CodeSniffer.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Running PHP CodeSniffer.');
        $this->info('');

        $args = [
            base_path().'/vendor/bin/phpcs',
            '--standard='.base_path().'/phpcs.xml',
            '-s',
            base_path().'/app/',
            //base_path().'/tests/'
        ];

        passthru(join(' ', $args), $code);

        if ($code) {
            $this->error('Check style FAILED!');
        }

    }
}
