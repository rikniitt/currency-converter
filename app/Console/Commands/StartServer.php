<?php

namespace CurrencyConverter\Console\Commands;

use Illuminate\Console\Command;

class StartServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curr:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start development server.';

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
        $this->call('serve', [
            '--host' => '0.0.0.0'
        ]);
    }
}
